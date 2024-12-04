<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payaddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'coin_name',
        'network',
        'blockchain',
        'address',
        'status',
    ];
}
