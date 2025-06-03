<?php

namespace Devadze\FlittPayment\Contracts;

interface PaymentGatewayContract
{
    public function redirect(): array;
    public function token(): array;
    public function recurring(): array;
    public function orderStatus(): array;
}

