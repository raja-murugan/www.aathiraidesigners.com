<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'soft_delete',
        'name',
        'phonenumber',
        'source_from',
        'employee_id'
    ];
}
