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
        'department_id',
        'phone_number',
        'salaray_per_hour',
        'ot_salary',
        'address',
        'photo',
        'aadhaar_card',
        'soft_delete'
    ];
}
