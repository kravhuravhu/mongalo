<?php

namespace App\Services;

use App\Contracts\PaymentGatewayInterface;
use App\Mail\OrderConfirmation;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PaymentService
{
    protected array $gateways = [];
    protected string $defaultGateway;

    public function __construct()
    {
        $this->defaultGateway = config('payment.default_gateway', 'payfast');
        $this->loadGateways();
    }

    /* ─── LOAD GATEWAYS ─── */
    protected function loadGateways(): void
    {
        $gatewayClasses = config('payment.gateways', [
            'payfast' => \App\Services\PaymentGateways\PayFastGateway::class,
        ]);

        foreach ($gatewayClasses as $name => $class) {
            try {
                if (class_exists($class)) {
                    $gateway = app($class);
                    if ($gateway instanceof PaymentGatewayInterface) {
                        $this->gateways[$name] = $gateway;
                    }
                }
            } catch (Throwable $e) {
                Log::error('Failed to load payment gateway: ' . $name, [
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /* ─── GET AVAILABLE GATEWAYS ─── */
    public function getAvailableGateways(): Collection
    {
        return collect($this->gateways)
            ->filter(fn($gateway) => $gateway->isAvailable());
    }

    /* ─── GET GATEWAY ─── */
    public function getGateway(?string $name = null): ?PaymentGatewayInterface
    {
        $name = $name ?? $this->defaultGateway;

        if (!isset($this->gateways[$name])) {
            Log::warning('Payment gateway not found', ['gateway' => $name]);
            return null;
        }

        return $this->gateways[$name];
    }

    /* ─── INITIATE PAYMENT ─── */
    public function initiatePayment(Book $book, array $buyerData, ?string $gatewayName = null): array
    {
        $gateway = $this->getGateway($gatewayName);

        if (!$gateway) {
            return [
                'success' => false,
                'message' => 'Payment gateway not available.',
            ];
        }

        if (!$gateway->isAvailable()) {
            return [
                'success' => false,
                'message' => 'Payment gateway is not configured.',
            ];
        }

        // ─── CREATE ORDER ───
        $order = Order::create([
            'book_id' => $book->id,
            'buyer_name' => $buyerData['name'],
            'buyer_email' => $buyerData['email'],
            'buyer_phone' => $buyerData['phone'] ?? null,
            'amount' => $book->price,
            'payment_status' => 'pending',
            'payment_method' => $gateway->getName(),
        ]);

        // ─── INITIATE PAYMENT ───
        try {
            $result = $gateway->initiate($order, $buyerData);

            if ($result['success']) {
                $order->update([
                    'payment_method' => $gateway->getName(),
                    'transaction_id' => $result['transaction_id'] ?? null,
                ]);

                Log::info('Payment initiated', [
                    'order_number' => $order->order_number,
                    'gateway' => $gateway->getName(),
                    'amount' => $order->amount,
                ]);
            }

            return array_merge($result, [
                'order' => $order,
                'order_number' => $order->order_number,
            ]);
        } catch (Throwable $e) {
            Log::error('Payment initiation failed', [
                'error' => $e->getMessage(),
                'book_id' => $book->id,
                'gateway' => $gateway->getName(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment initiation failed. Please try again.',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function processPaymentResponse(array $data, ?string $gatewayName = null): array
    {
        $gateway = $this->getGateway($gatewayName);

        if (!$gateway) {
            Log::error('Invalid payment gateway', ['gateway' => $gatewayName]);
            return [
                'success' => false,
                'message' => 'Invalid payment gateway.',
            ];
        }

        try {
            $result = $gateway->processResponse($data);

            // ─── LOG THE RESULT ───
            Log::info('Payment processing result', [
                'success' => $result['success'],
                'gateway' => $gateway->getName(),
                'order_number' => $result['order_number'] ?? 'unknown',
                'status' => $result['status'] ?? 'unknown',
            ]);

            // ─── UPDATE ORDER STATUS ───
            $orderNumber = $result['order_number'] ?? null;
            
            if ($orderNumber) {
                $order = Order::where('order_number', $orderNumber)->first();
                if ($order) {
                    if ($result['success']) {
                        $order->update([
                            'payment_status' => 'paid',
                            'transaction_id' => $result['transaction_id'] ?? $order->transaction_id,
                        ]);

                        Log::info('Order updated to PAID', [
                            'order_number' => $order->order_number,
                            'gateway' => $gateway->getName(),
                        ]);

                        // ─── SEND CONFIRMATION EMAIL ───
                        $this->sendOrderConfirmation($order);
                    } else {
                        // ─── CHECK IF STATUS IS PENDING ───
                        $status = $result['status'] ?? 'unknown';
                        if (strtoupper($status) === 'PENDING') {
                            Log::info('Payment pending, waiting for confirmation', [
                                'order_number' => $order->order_number,
                                'status' => $status,
                            ]);
                        } else {
                            $order->update([
                                'payment_status' => 'failed',
                            ]);
                            
                            Log::warning('Order updated to FAILED', [
                                'order_number' => $order->order_number,
                                'status' => $status,
                            ]);
                        }
                    }
                } else {
                    Log::warning('Order not found', ['order_number' => $orderNumber]);
                }
            } else {
                Log::warning('No order number in payment response', [
                    'data_keys' => array_keys($data),
                ]);
            }

            return $result;
        } catch (Throwable $e) {
            Log::error('Payment processing failed', [
                'error' => $e->getMessage(),
                'gateway' => $gateway->getName(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment processing failed.',
                'error' => $e->getMessage(),
            ];
        }
    }

    /* ─── VERIFY PAYMENT ─── */
    public function verifyPayment(string $transactionId, ?string $gatewayName = null): array
    {
        $gateway = $this->getGateway($gatewayName);

        if (!$gateway) {
            return [
                'success' => false,
                'message' => 'Invalid payment gateway.',
            ];
        }

        try {
            return $gateway->verify($transactionId);
        } catch (Throwable $e) {
            Log::error('Payment verification failed', [
                'error' => $e->getMessage(),
                'transaction_id' => $transactionId,
                'gateway' => $gateway->getName(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment verification failed.',
                'error' => $e->getMessage(),
            ];
        }
    }

    /* ─── SEND ORDER CONFIRMATION EMAIL ─── */
    protected function sendOrderConfirmation(Order $order): void
    {
        try {
            Mail::to($order->buyer_email)->send(new OrderConfirmation($order));
            
            Log::info('Order confirmation email sent', [
                'order_number' => $order->order_number,
                'email' => $order->buyer_email,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to send order confirmation email', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
            ]);
        }
    }
}