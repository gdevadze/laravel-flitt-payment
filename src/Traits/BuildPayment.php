<?php

namespace Devadze\FlittPayment\Traits;

use Devadze\FlittPayment\Models\FlittPaymentTransaction;
use Illuminate\Database\Eloquent\Model;

trait BuildPayment
{
    protected array $payload;
    protected bool $orderIdManuallySet = false;

    protected $model_id = null;
    protected $model_type = '';

    public function resetPayload($data = null): void
    {
        $autoGenerate = config('flitt.auto_order_id');

        if ($autoGenerate) {
            $orderId = uniqid('flitt_', true);
        } else {
            $orderId = $this->payload['order_id'] ?? null;
        }

        $this->payload = $data ?? [
            'merchant_id' => config('flitt.merchant_id'),
            'currency' => config('flitt.currency'),
            'order_id' => $orderId,
            'server_callback_url' => config('flitt.callback_url'),
            'response_url' => config('flitt.response_url'),
            'lang' => config('flitt.lang'),
            'design_id' => config('flitt.design_id')
        ];
    }

    public function for(Model $model = null)
    {
        $this->model_id = $model ? data_get($model, 'id') : null;
        $this->model_type = $model ? get_class($model) : null;
        return $this;
    }

    public function setOrderId(string $orderId): self
    {
        $this->payload['order_id'] = $orderId;
        $this->orderIdManuallySet = true;
        return $this;
    }

    public function setAmount(int $amount): self
    {
        $this->payload['amount'] = $amount * 100;
        return $this;
    }

    public function setCurrency(string $currency = 'GEL'): self
    {
        $supportedCurrencies = ['GEL', 'USD', 'EUR'];

        if (! in_array(strtoupper($currency), $supportedCurrencies)) {
            throw new \InvalidArgumentException("Unsupported currency: $currency. Allowed: " . implode(', ', $supportedCurrencies));
        }

        $this->payload['currency'] = $currency;
        return $this;
    }

    public function setOrderDesc(string $description): self
    {
        $this->payload['order_desc'] = $description;
        return $this;
    }

    public function setCallbackUrl(string $url): self
    {
        $this->payload['server_callback_url'] = $url;
        return $this;
    }

    protected function logTransactionCreate(array $data)
    {
        FlittPaymentTransaction::create([
            'locale' => config('flitt.lang'),
            'model_id' => $this->model_id ?? null,
            'model_type' => $this->model_type ?? null,
            'amount' => $this->payload['amount'] / 100,
            'status' => 'created',
            'payment_id' => $data['payment_id'],
            'order_id' => $data['order_id'] ?? null
        ]);
    }
}
