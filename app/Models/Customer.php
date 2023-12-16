<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;


    protected $fillable = [
        'unique_key',
        'soft_delete',
        'name',
        'phonenumber',
        'alter_phonenumber',
        'email_id',
        'address',
        'source_from',
        'customer_photo',
        'birth_date',
        'wedding_date',
        'employee_id'
    ];
}
