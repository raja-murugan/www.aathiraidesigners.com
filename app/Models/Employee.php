<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;


    protected $fillable = [
        'unique_key',
        'name',
        'phone_number',
        'salaray_per_hour',
        'address',
        'photo',
        'soft_delete'
    ];
}
