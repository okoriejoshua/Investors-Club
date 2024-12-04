<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usersettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'theme',
        'is_lock',
        'is_2fa',
        'is_wpin',
        'wpin',
    ];
}
