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
        'date',
        'employee_id',
        'working_hour',
        'checkin_date',
        'checkin_time',
        'checkout_date',
        'checkout_time',
        'checkin_photo',
        'checkout_photo',
        'status',
    ];
}
