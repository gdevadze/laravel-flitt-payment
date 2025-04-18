<?php

namespace Devadze\FlittPayment;

use Devadze\FlittPayment\Contracts\PaymentGatewayContract;
use Illuminate\Support\ServiceProvider;

class FlittPaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentGatewayContract::class, FlittPayment::class);
        $this->app->singleton('flitt.payment', function ($app) {
            return $app->make(PaymentGatewayContract::class);
        });

        $this->mergeConfigFrom(__DIR__.'/../config/flitt.php', 'flitt');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->publishes([
            __DIR__.'/../config/flitt.php' => config_path('flitt.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations/create_flitt_payment_transactions_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time() - 10) . '_create_flitt_payment_transactions_table.php'),
        ], 'migrations');
    }
}
