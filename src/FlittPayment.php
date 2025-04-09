<?php

namespace Devadze\FlittPayment;

use Devadze\FlittPayment\Contracts\PaymentGatewayContract;
use Devadze\FlittPayment\Models\FlittPaymentTransaction;
use Devadze\FlittPayment\Traits\BuildPayment;

class FlittPayment extends ApiRequest implements PaymentGatewayContract
{
    use BuildPayment;

    public ApiRequest $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
        $this->resetPayload();
    }

    public function redirect()
    {
        $response = $this->apiRequest->post('checkout/url',$this->payload);

        if ($response['response']['response_status'] == 'success'){
            $this->logTransactionCreate([
                'payment_id' => $response['response']['payment_id']
            ]);
            $this->resetPayload();
            return redirect($response['response']['checkout_url']);
        }

        return $response;
    }
}
