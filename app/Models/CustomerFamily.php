<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFamily extends Model
{
    use HasFactory;


    protected $fillable = [
        'customer_id',
        'family_name',
        'family_relationship',
        'family_dob',
        'family_weddingdate'
    ];
}
