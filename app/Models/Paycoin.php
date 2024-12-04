<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paycoin extends Model
{
    use HasFactory;
    protected $fillable = [
        'coin_name',
        'image',
        'deposit',
        'withdraw',
        'status',
    ];
    
}
