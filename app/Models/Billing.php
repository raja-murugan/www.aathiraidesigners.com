<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_key',
        'date',
        'time',
        'delivery_date',
        'delivery_time',
        'billno',
        'customer_id',
        'total_amount',
        'discount_type',
        'discount',
        'note',
        'total_discountamount',
        'grand_total',
        'total_paid_amount',
        'total_balance_amount',
        'status',
        'soft_delete',
    ];
}
