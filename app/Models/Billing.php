<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_key',
        'soft_delete',
        'customer_id',
        'product_id',
        'date',
        'employee_id',
        'starting_date',
        'ending_date',
        'remainder_date'
    ];
}
