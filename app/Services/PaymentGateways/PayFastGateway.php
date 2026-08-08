<?php

namespace App\Services\PaymentGateways;

use App\Abstracts\BasePaymentGateway;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayFastGateway extends BasePaymentGateway
{
    protected function getDefaultName(): string
    {
        return 'payfast';
    }

    protected function getDefaultConfig(): array
    {
        return [
            'environment' => env('PAYFAST_ENVIRONMENT', 'sandbox'),
            'merchant_id' => env('PAYFAST_MERCHANT_ID', ''),
            'merchant_key' => env('PAYFAST_MERCHANT_KEY', ''),
            'passphrase' => env('PAYFAST_PASSPHRASE', ''),
            'active' => env('PAYFAST_ACTIVE', true),
        ];
    }

    protected function getMerchantCredentials(): array
    {
        return [
            'merchant_id' => $this->config['merchant_id'],
            'merchant_key' => $this->config['merchant_key'],
            'passphrase' => $this->config['passphrase'],
        ];
    }

    public function initiate(Order $order, array $data = []): array
    {
        $this->log('Initiating payment', [
            'order_number' => $order->order_number,
            'amount' => $order->amount,
            'gateway' => $this->getName(),
        ]);

        $payload = $this->buildPayload($order, $data);

        // ─── IN SANDBOX MODE, LOG PAYLOAD ───
        if ($this->isSandbox()) {
            $this->log('PayFast Sandbox Payload', $payload);
        }

        return [
            'success' => true,
            'gateway' => $this->getName(),
            'order_number' => $order->order_number,
            'amount' => $order->amount,
            'redirect_url' => $this->getCheckoutUrl($order),
            'form_data' => $payload,
            'is_sandbox' => $this->isSandbox(),
        ];
    }

    public function processResponse(array $data): array
    {
        $this->log('Processing payment response', [
            'data' => $data,
        ]);

        // ─── CHECK IF DATA IS EMPTY ───
        if (empty($data)) {
            $this->logError('Empty payment response data');
            return [
                'success' => false,
                'message' => 'No payment data received.',
            ];
        }

        // ─── GET ORDER NUMBER ───
        $orderNumber = $data['m_payment_id'] ?? null;
        
        // ─── GET TRANSACTION ID ───
        $transactionId = $data['pf_payment_id'] ?? null;
        
        // ─── CHECK PAYMENT STATUS - BOTH FIELD NAMES ───
        $status = $data['payment_status'] ?? $data['pf_payment_status'] ?? 'failed';
        $this->log('Payment status from PayFast', ['status' => $status]);

        // ─── PAYFAST STATUS CODES ───
        $isPaid = in_array(strtoupper($status), ['COMPLETE', 'PAID']);
        $isPending = strtoupper($status) === 'PENDING';

        if ($isPaid) {
            $this->log('Payment successful', [
                'order_number' => $orderNumber,
                'payment_id' => $transactionId,
            ]);
        } elseif ($isPending) {
            $this->log('Payment pending', [
                'order_number' => $orderNumber,
                'payment_id' => $transactionId,
            ]);
        } else {
            $this->logWarning('Payment not completed', [
                'order_number' => $orderNumber,
                'status' => $status,
            ]);
        }

        return [
            'success' => $isPaid,
            'gateway' => $this->getName(),
            'transaction_id' => $transactionId,
            'status' => $status,
            'order_number' => $orderNumber,
            'raw_data' => $data,
        ];
    }

    public function verify(string $transactionId): array
    {
        $this->log('Verifying payment', [
            'transaction_id' => $transactionId,
        ]);

        // ─── PAYFAST VERIFICATION ENDPOINT ───
        $url = $this->getVerificationUrl();

        try {
            $response = Http::asForm()->post($url, [
                'pf_payment_id' => $transactionId,
            ]);

            $body = $response->body();

            if (strpos($body, 'PAYMENT_STATUS=COMPLETE') !== false) {
                return [
                    'success' => true,
                    'status' => 'complete',
                    'gateway' => $this->getName(),
                ];
            }

            return [
                'success' => false,
                'status' => 'failed',
                'gateway' => $this->getName(),
            ];
        } catch (\Exception $e) {
            $this->logError('Verification failed', [
                'error' => $e->getMessage(),
                'transaction_id' => $transactionId,
            ]);

            return [
                'success' => false,
                'status' => 'error',
                'gateway' => $this->getName(),
                'message' => $e->getMessage(),
            ];
        }
    }

    /* ─── BUILD PAYLOAD ─── */
    private function buildPayload(Order $order, array $data = []): array
    {
        $payload = [
            // ─── MERCHANT DETAILS ───
            'merchant_id' => $this->config['merchant_id'],
            'merchant_key' => $this->config['merchant_key'],

            // ─── ORDER DETAILS ───
            'm_payment_id' => $order->order_number,
            'amount' => number_format($order->amount, 2, '.', ''),
            'item_name' => $order->book->title ?? 'Book Purchase',

            // ─── BUYER DETAILS ───
            'name_first' => explode(' ', $order->buyer_name)[0] ?? $order->buyer_name,
            'name_last' => explode(' ', $order->buyer_name)[1] ?? '',
            'email_address' => $order->buyer_email,
            'cell_number' => $order->buyer_phone ?? '',

            // ─── URLS ───
            'return_url' => $this->getReturnUrl(),
            'cancel_url' => $this->getCancelUrl(),
            'notify_url' => $this->getWebhookUrl(),

            // ─── CUSTOM FIELDS ───
            'custom_str1' => $order->id,
            'custom_str2' => $order->book->id ?? '',
        ];

        // ─── ADD PASS PHRASE IF SET ───
        if (!empty($this->config['passphrase'])) {
            $payload['passphrase'] = $this->config['passphrase'];
        }

        return $payload;
    }

    /* ─── SIGNATURE VERIFICATION ─── */
    private function verifySignature(array $data): bool
    {
        // ─── CHECK REQUIRED FIELDS ───
        $required = ['pf_payment_id', 'pf_payment_status', 'pf_signature'];
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                $this->logError('Missing required field', ['field' => $field]);
                return false;
            }
        }

        // ─── BUILD SIGNATURE STRING ───
        $signatureString = '';
        $signatureData = array_filter($data, function ($key) {
            return strpos($key, 'pf_') === 0 && $key !== 'pf_signature';
        }, ARRAY_FILTER_USE_KEY);

        ksort($signatureData);

        foreach ($signatureData as $key => $value) {
            $signatureString .= $key . '=' . urlencode(trim($value)) . '&';
        }
        $signatureString = rtrim($signatureString, '&');

        // ─── ADD PASS PHRASE ───
        if (!empty($this->config['passphrase'])) {
            $signatureString .= '&passphrase=' . urlencode(trim($this->config['passphrase']));
        }

        // ─── GENERATE AND COMPARE SIGNATURE ───
        $generatedSignature = md5($signatureString);

        $result = strtolower($data['pf_signature']) === strtolower($generatedSignature);
        
        if (!$result) {
            $this->logError('Signature mismatch', [
                'received' => $data['pf_signature'],
                'generated' => $generatedSignature,
                'string' => $signatureString,
            ]);
        }

        return $result;
    }

    /* ─── GET URLS ─── */
    private function getVerificationUrl(): string
    {
        return $this->isSandbox()
            ? 'https://sandbox.payfast.co.za/eng/query/validate'
            : 'https://www.payfast.co.za/eng/query/validate';
    }

    public function getCheckoutUrl(Order $order): string
    {
        return route('payment.checkout', [
            'gateway' => $this->getName(),
            'order' => $order->order_number,
        ]);
    }

    public function getWebhookUrl(): string
    {
        return route('payment.webhook', ['gateway' => $this->getName()]);
    }

    public function getReturnUrl(): string
    {
        return route('payment.return', ['gateway' => $this->getName()]);
    }

    public function getCancelUrl(): string
    {
        return route('payment.cancel', ['gateway' => $this->getName()]);
    }
}