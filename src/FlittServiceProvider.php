<?php

namespace Devadze\FlittPayment;

use Devadze\FlittPayment\Contracts\PaymentGatewayContract;
use Devadze\FlittPayment\Services\FlittService;
use Illuminate\Support\ServiceProvider;

class FlittServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentGatewayContract::class, FlittPayment::class);
        $this->app->singleton('flitt.payment', function ($app) {
            return $app->make(PaymentGatewayContract::class);
        });

//        $this->mergeConfigFrom(__DIR__.'/../config/flitt.php', 'flitt');
    }

    public function boot()
    {
//        $this->publishes([
//            __DIR__.'/../config/flitt.php' => config_path('flitt.php'),
//        ], 'config');
    }
}
