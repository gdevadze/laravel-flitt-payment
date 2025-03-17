<?php

namespace Devadze\FlittPayment\Contracts;

interface PaymentGatewayContract
{
    public function createCheckoutUrl(string $orderId, int $amount, string $description): array;
}
