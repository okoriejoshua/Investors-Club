<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'name',
        'slug',
        'category',
        'min_price',
        'max_price',
        'duration',
        'numdays',
        'return_type',
        'status',
        'profit',
        'counts',
    ];

}
