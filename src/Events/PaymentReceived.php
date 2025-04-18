<?php

namespace Devadze\FlittPayment\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentReceived
{
    use Dispatchable, SerializesModels;

    public array $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }
}
