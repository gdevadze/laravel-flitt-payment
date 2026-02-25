<?php

namespace Devadze\FlittPayment;

use Devadze\FlittPayment\Concerns\ApiRequest;
use Devadze\FlittPayment\Contracts\PaymentGatewayContract;

class FlittPayment extends ApiRequest implements PaymentGatewayContract
{
    public ApiRequest $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
        $this->resetPayload();
    }

    public function redirect(): array
    {
        $response = $this->apiRequest->post('checkout/url',$this->payload);
//        return $response;
        if ($response['response']['response_status'] == 'success'){
            $this->logTransactionCreate([
                'payment_id' => $response['response']['payment_id']
            ]);
        }

        $this->resetPayload();

        return $response['response'];
    }

    public function token(): array
    {
        $response = $this->apiRequest->post('checkout/token',$this->payload);

        if ($response['response']['response_status'] == 'success'){
            $this->logTransactionCreate([
                'order_id' => $this->payload['order_id'],
                'payment_id' => $response['response']['payment_id'] ?? null
            ]);
        }

        $this->resetPayload();

        return $response['response'];
    }

    public function recurring(): array
    {
        unset(
            $this->payload['response_url'],
            $this->payload['lang'],
            $this->payload['design_id']
        );
        $response = $this->apiRequest->post('recurring',$this->payload);

        $this->resetPayload();

        return $response['response'];
    }

    public function orderStatus(): array
    {
        unset(
            $this->payload['server_callback_url'],
            $this->payload['response_url'],
            $this->payload['currency'],
            $this->payload['lang'],
            $this->payload['design_id']
        );
        $response = $this->apiRequest->post('status/order_id',$this->payload);

        $this->resetPayload();

        return $response['response'];
    }

    public function reversal(): array
    {
        unset(
            $this->payload['server_callback_url'],
            $this->payload['response_url'],
            $this->payload['lang'],
            $this->payload['design_id']
        );
        $response = $this->apiRequest->post('reverse/order_id',$this->payload);

        $this->resetPayload();

        return $response['response'];
    }
}
