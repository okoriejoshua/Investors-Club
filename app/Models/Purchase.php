<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'user_id',
        'plan_name',
        'plan_id',
        'type',
        'apr',
        'purchase_id',
        'amount',
        'duration',
        'total_profit',
        'current_profit',
        'return_type',
        'original_hour',
        'progress_counter',
        'initial_hour',
        'next_halving',
        'status', 
        'is_completed',
        'is_refunded',
        'is_terminated',
        'is_cost_paidback',
    ];
}
