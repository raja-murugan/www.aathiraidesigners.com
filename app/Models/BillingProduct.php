<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_id',
        'billing_product_id',
        'billing_measurement',
        'billing_qty',
        'billing_rateperqty',
        'billing_total',
    ];
}
