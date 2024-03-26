<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProductMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_product_id',
        'product_id',
        'measurement_id', 
        'measurement_name',
        'measurement_no'
    ];
}
