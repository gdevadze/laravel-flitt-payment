<?php

namespace Devadze\FlittPayment\Models;

use Illuminate\Database\Eloquent\Model;

class FlittPaymentTransaction extends Model
{
    protected $fillable = [
        'locale',
        'model_id',
        'model_type',
        'amount',
        'payment_id',
        'order_id',
        'is_paid',
        'completed_at'
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
