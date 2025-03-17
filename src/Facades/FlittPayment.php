<?php

namespace Devadze\FlittPayment\Facades;

use Illuminate\Support\Facades\Facade;

class FlittPayment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flitt.payment';
    }
}
