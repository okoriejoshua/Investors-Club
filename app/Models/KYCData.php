<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KYCData extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name_on_card',
        'card_type',
        'country_issued',
        'card_front',
        'card_back',
        'serial_number',
        'status',
        'expiry',
        'steps',
    ];
    
}
