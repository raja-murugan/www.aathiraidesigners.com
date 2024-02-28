<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payoffdata extends Model
{
    use HasFactory;

    protected $fillable = [
        'payoff_id',
        'date',
        'time',
        'month',
        'year',
        'employee_id',
        'total_working_hour',
        'perhoursalary',
        'salaryamount',
        'paidsalary',
        'balancesalary',
        'note',
        'soft_delete'
    ];
}
