<?php

use App\Http\Livewire\Admin\ListUsers;
use App\Http\Livewire\Admin\AdminDashboard;
use App\Http\Livewire\Admin\ListAdmins;
use App\Http\Livewire\Admin\ViewProfile;
use App\Http\Livewire\Admin\Deposits;
use App\Http\Livewire\Admin\Investments;
use App\Http\Livewire\Admin\ListInvestments;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'checkUser'])->group(function () {
    Route::get('dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('users', ListUsers::class)->name('admin.users');
    Route::get('admins', ListAdmins::class)->name('admin.admins');
    Route::get('profile', ViewProfile::class)->name('admin.profile');
    Route::get('deposits', Deposits::class)->name('admin.deposits');
    Route::get('investments', Investments::class)->name('admin.investments');
    Route::get('manage-investments', ListInvestments::class)->name('admin.list-investments');
});
