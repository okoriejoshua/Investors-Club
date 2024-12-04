<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        if (Auth::check()) {
            if (Auth::user()->type == 'admin') {
                return redirect('admin/dashboard');
            } elseif (Auth::user()->type == 'user') {
                return redirect('user/dashboard');
            } else {
                return redirect(401);
            }
        }
    });
});
