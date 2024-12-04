<?php

use App\Http\Livewire\User\UserDashboard;
use App\Http\Livewire\User\PurchasePlan;
use App\Http\Livewire\User\Deposits;
use App\Http\Livewire\User\Withdraw;
use App\Http\Livewire\User\Profile;
use App\Http\Livewire\User\Stake;
use App\Http\Livewire\User\Settings;
use App\Http\Livewire\User\Transfer;
use App\Http\Livewire\User\History;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->middleware(['auth', 'checkUser'])->group(function () {
    Route::get('dashboard', UserDashboard::class)->name('user.dashboard');
    Route::get('purchase-plan/{tab?}', PurchasePlan::class)->name('user.purchase');
    Route::get('stake/{tab?}', Stake::class)->name('user.stake');
    Route::get('settings/{tab?}', Settings::class)->name('user.settings');
    Route::get('deposits/', Deposits::class)->name('user.deposit');
    Route::get('withdraw/', Withdraw::class)->name('user.withdraw');
    Route::get('transfer/', Transfer::class)->name('user.transfer');
    Route::get('profile', Profile::class)->name('user.profile');
    Route::get('transactions/', History::class)->name('user.history');
});