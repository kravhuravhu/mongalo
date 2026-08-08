<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentGatewayInterface
{
    /**
     * Initialize a payment
     * 
     * @param Order $order
     * @param array $data
     * @return array
     */
    public function initiate(Order $order, array $data = []): array;

    /**
     * Process payment response
     * 
     * @param array $data
     * @return array
     */
    public function processResponse(array $data): array;

    /**
     * Verify payment status
     * 
     * @param string $transactionId
     * @return array
     */
    public function verify(string $transactionId): array;

    /**
     * Get payment gateway name
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Check if gateway is available
     * 
     * @return bool
     */
    public function isAvailable(): bool;

    /**
     * Get checkout URL
     * 
     * @param Order $order
     * @return string
     */
    public function getCheckoutUrl(Order $order): string;

    /**
     * Get webhook URL
     * 
     * @return string
     */
    public function getWebhookUrl(): string;

    /**
     * Get return URL (success)
     * 
     * @return string
     */
    public function getReturnUrl(): string;

    /**
     * Get cancel URL
     * 
     * @return string
     */
    public function getCancelUrl(): string;
}