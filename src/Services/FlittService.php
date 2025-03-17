<?php

namespace Devadze\FlittPayment\Services;

use GuzzleHttp\Client;
use Devadze\FlittPayment\Contracts\PaymentGatewayContract;
use Devadze\FlittPayment\Traits\SignatureGenerator;

class FlittService implements PaymentGatewayContract
{
    use SignatureGenerator;

    protected Client $client;
    protected array $config;

    public function __construct()
    {
        $this->client = new Client();
        $this->config = config('flitt');
    }

    public function createCheckoutUrl(string $orderId, int $amount, string $description): array
    {
        $data = [
            "request" => [
                "server_callback_url" => $this->config['callback_url'],
                "order_id" => $orderId,
                "currency" => "GEL",
                "merchant_id" => $this->config['merchant_id'],
                "order_desc" => $description,
                "amount" => $amount,
                "signature" => $this->generateSignature($orderId, $amount)
            ]
        ];

        $response = $this->client->post('https://pay.flitt.com/api/checkout/url', [
            'json' => $data,
            'headers' => ['Content-Type' => 'application/json']
        ]);

        return json_decode($response->getBody(), true);
    }
}
