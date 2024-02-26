<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_key',
        'date',
        'time',
        'amount',
        'description',
        'soft_delete'
    ];
}
