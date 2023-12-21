<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'year',
        'checkin_date',
        'checkin_time',
        'employee_id',
        'checkout_date',
        'checkout_time',
        'working_hour',
        'status',
        'soft_delete'
    ];
}
