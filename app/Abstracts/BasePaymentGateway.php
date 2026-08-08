<?php

namespace App\Abstracts;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

abstract class BasePaymentGateway implements PaymentGatewayInterface
{
    protected string $name;
    protected bool $isActive;
    protected string $environment;
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->getDefaultConfig(), $config);
        $this->environment = $this->config['environment'] ?? 'sandbox';
        $this->isActive = $this->config['active'] ?? true;
        $this->name = $this->getDefaultName();
    }

    /* ─── ABSTRACT METHODS ─── */
    abstract protected function getDefaultConfig(): array;
    abstract protected function getDefaultName(): string;

    /* ─── COMMON IMPLEMENTATIONS ─── */
    public function getName(): string
    {
        return $this->name;
    }

    public function isAvailable(): bool
    {
        return $this->isActive && !empty($this->getMerchantCredentials());
    }

    public function getCheckoutUrl(Order $order): string
    {
        return route('payment.checkout', [
            'gateway' => $this->getName(),
            'order' => $order->order_number
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

    /* ─── HELPERS ─── */
    protected function log(string $message, array $context = []): void
    {
        Log::info($this->getName() . ': ' . $message, $context);
    }

    protected function logError(string $message, array $context = []): void
    {
        Log::error($this->getName() . ': ' . $message, $context);
    }

    protected function logWarning(string $message, array $context = []): void
    {
        Log::warning($this->getName() . ': ' . $message, $context);
    }

    abstract protected function getMerchantCredentials(): array;

    protected function isSandbox(): bool
    {
        return $this->environment === 'sandbox' || $this->environment === 'test';
    }

    protected function getCurrency(): string
    {
        return 'ZAR';
    }
}