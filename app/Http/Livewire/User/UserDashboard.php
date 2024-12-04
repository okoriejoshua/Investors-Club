<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\User\UserComponent;
use App\Models\Planstype;
use App\Models\Investment;

class UserDashboard extends UserComponent
{

    public $plans = null;
    public $staking = null; 
    

   /* public function openBuyModal($planId)
    {
        $this->redirect(route('user.purchase', ['tab' => $plan->category]));
    }*/
    public function render()
    {
        $this->staking = Investment::query()->where('category', 'crypto')
        ->where('status', 'active')->latest()->get();
        $this->plans = Planstype::query()->where('status', 'active')->latest()->get();
        return view('livewire.user.user-dashboard', [ 'plans' => $this->plans, 'stakes'=> $this->staking])->layout('layouts.user'); 
    }
}
