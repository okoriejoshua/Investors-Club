<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stakingcoin extends Model
{
    use HasFactory;
    protected $fillable = [
        'coin_name',
        'short_duration',
        'mid_duration',
        'long_duration',
        'short_apr',
        'mid_apr',
        'long_apr',
        'status',
    ];
}
