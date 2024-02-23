<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_id',
        'payment_term',
        'payment_paid_date',
        'payment_paid_amount',
        'payment_method',
    ];
}
