<?php

namespace Devadze\FlittPayment;

use Devadze\FlittPayment\Traits\SignatureGenerator;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiRequest
{
    use SignatureGenerator;
    protected string $endpoint = 'https://pay.flitt.com/api/';

    private function handleResponse($response): mixed
    {
        if ($response->successful()) {
            return $response->json();
        }

        // Log error details
        Log::error('API Request Failed', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        throw new Exception('API request failed with Flitt Payment.'.$response->body());
    }

    public function __call($name, $arguments)
    {
        if (! in_array($name, ['get', 'post', 'put', 'delete'])) {
            throw new Exception('Method not allowed');
        }
        $endpoint = $arguments[0];
        $payload = $arguments[1] ?? [];

        $payload['signature'] = $this->generateSignature($payload);

        try {
            $url = $this->endpoint.$endpoint;

            $response = Http::{$name}($url, ['request' => $payload]);

            return $this->handleResponse($response);
        } catch (Exception $e) {
            Log::error('GET Request Exception: '.$e->getMessage());
            throw $e;
        }
    }
}
