<?php

use Illuminate\Support\Facades\Route;
use Devadze\FlittPayment\Http\Controllers\CallbackController;

Route::group(['prefix' => 'flitt-payment', 'as' => 'flitt-payment.'], function () {
    Route::any('/callback', CallbackController::class)->name('callback');
});
