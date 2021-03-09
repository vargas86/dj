<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = ['subscription_id', 'stripe_payment_id', 'stripe_price_id', 'payment_intent', 'amount_paid', 'currency', 'status', 'insctuctor_amount', 'period_start', 'period_end'] ;
}
