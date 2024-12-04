<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\User\UserComponent;
use App\Models\Planstype;
use App\Models\Investment;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\validator;


class PurchasePlan extends UserComponent
{

    public $tab = 'category';
    public $selectedPlan = null; 
    public $tabData = null;
    public $state = [];


    public function render()
    {
        $categories = Planstype::query()->where('status', 'active')->latest()->get();
        $tab = $this->tab; 

        $plans = Investment::query()->where('category', $tab)
            ->where('status', 'active')->latest()->get();

        return view('livewire.user.purchase-plan', [
            'categories' => $categories,
            'plans' => $plans,
            'tab' => $this->tab,
            'tabdata' => $this->tabData,
        ])->layout('layouts.user');
    }

    public function mount()
    {
        //do not remove
        //$tab = $this->tab; 
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
        $this->tabData = Planstype::query()
            ->where('slug', $tab)
            ->where('status', 'active')
            ->first();

        $this->dispatchBrowserEvent('show-tabModal');
    }

  
    public function openBuyModal($planId)
    {
        $this->state = [];
        $this->selectedPlan = Investment::findOrFail($planId);
        $this->state = $this->selectedPlan->toArray();
        $this->dispatchBrowserEvent('show-buyModal');
    }


    public function createPurchase()
    {
        $validatedData = Validator::make($this->state, [
            'amount' => [
                'required',
                'numeric',
                'min:' . $this->selectedPlan->min_price,
                'max:' . min(auth()->user()->bal, $this->selectedPlan->max_price),
            ],
        ])->validate();

        $existingPurchase = Purchase::where('plan_id', $this->selectedPlan->id)
            ->where('user_id', auth()->user()->user_id)
            ->where('status', 'active')
            ->where('is_completed', false)
            ->first();

        if ($existingPurchase) {
            $isSuccess = false;
            $responseMsg = $existingPurchase->plan_name . ' has already been purchased!';
        } else {
            $duration = Carbon::now();
            $nextHalving = Carbon::now();

            if ($this->selectedPlan->return_type === 'hours') {
                $duration->addHours($this->selectedPlan->numdays);
                $nextHalving->addHour();
            } else {
                $duration->addDays($this->selectedPlan->numdays);
                $nextHalving->addDay();
            }

            $realProfit = ($this->selectedPlan->profit / 100) * $validatedData['amount'];

            $purchase = Purchase::create([
                'user_id' => auth()->user()->user_id,
                'plan_name' => $this->selectedPlan->name,
                'plan_id' => $this->selectedPlan->id,
                'purchase_id' => strtoupper(str_shuffle(uniqid())),
                'amount' => $validatedData['amount'],
                'duration' => $duration,
                'total_profit' => $realProfit,
                'apr' => $this->selectedPlan->profit,
                'current_profit' => 0,
                'return_type' => $this->selectedPlan->return_type,
                'original_hour' => $this->selectedPlan->numdays,
                'progress_counter' => 0,
                'initial_hour' => $this->selectedPlan->numdays,
                'next_halving' => $nextHalving,
                'status' => 'active',
            ]);

            if ($purchase) {
                $user = User::findOrFail(auth()->user()->id);
                $user->bal -= $validatedData['amount'];
                $user->save();
            }
            $isSuccess = true;
            $responseMsg = $this->selectedPlan->name . ' purchased successfully';
        }

        $this->dispatchBrowserEvent('hide-purchaseForm', ['check' => $isSuccess, 'message' => $responseMsg]);
    }
}



