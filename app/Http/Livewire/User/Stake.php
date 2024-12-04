<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\User\UserComponent;
use App\Models\Stakewallet;
use App\Models\Stakingcoin;
use App\Models\Purchase;
use Carbon\Carbon;


class Stake extends UserComponent
{
    public $perPage = 10; 
    public $hasMore = true;
    public $activestake = []; 

    public $staking = null;
    public $tab = 'new';
    public $coindata = null;

    public $step = 0;
    public $amount = 0;
    public $radioDuration = null;
    public $isButtonDisabled = 'disabled';
    public $tabTitle = '';

    public $availableBalance = 0;
    public $selectedPercentage = 0;

    public $apr = 0;
    public $earnings = 0;
    public $walletInfo = null; 
    public $futureDate = null;
    

    public function render()
    {
        $tab = $this->tab;

        $this->activestake = Purchase::query()
            ->select('purchases.*', 'investments.photo')
            ->join('investments', 'investments.slug', '=', 'purchases.plan_name')
            ->where('purchases.is_completed', false)
            ->where('purchases.user_id', auth()->user()->user_id)
            ->latest()
            ->offset(($this->page - 1) * $this->perPage)
            ->limit($this->perPage)
            ->get();



        $this->staking = Stakingcoin::query()
            ->select('stakingcoins.*', 'investments.photo')
            ->join('investments', 'investments.slug', '=', 'stakingcoins.coin_name')
            ->where('stakingcoins.status', true)
            ->latest()
            ->get();

        $this->coindata = $this->staking->where('coin_name', $tab)->first();

        $this->walletInfo = Stakewallet::query()
            ->where('user_id', auth()->user()->id)
            ->where('coin', $tab)
            ->where('status', 'open')->first();
        $this->availableBalance = $this->walletInfo->amount ?? 0;

        $this->tabTitle = $this->makeTitle();
        $this->isButtonDisabled = $this->checkRadio();

        return view(
            'livewire.user.stake',
            [
                'stakes' => $this->staking,
                'coindata' => $this->coindata,
                'activestake' => $this->activestake,
                'tab' => $tab,
                'btnState' => $this->isButtonDisabled,
                'tabTitle' => $this->tabTitle,
                'step' => $this->step,
            ]
        )->layout('layouts.user');
    }

    public function loadMore()
    {
        $this->page++;
    }
    


    public function checkRadio()
    {
        if ($this->radioDuration == null) {
            return  'disabled';
        } elseif ($this->step === 1 && $this->amount <= 0) {
            return 'disabled';
        } else {
            return '';
        }
    }
    public function makeTitle()
    {
        if ($this->step === 0) {

            return 'Choose Staking Duration';
        } elseif ($this->step === 1) {

            return  'Staking Amount';
        } elseif ($this->step === 2) {

            return 'Confirm Staking';
        } else {

            return 'Choose Staking Duration';
        }
    }

    public function nextStep()
    {
        if ($this->step === 0) {

            if (!$this->radioDuration) {
                return;
            }
            $this->step = 1;
            $this->isButtonDisabled = '';
        } elseif ($this->step === 1) {

            if ($this->amount <= 0) {
                return;
            }

            /**Calc Apr */
            $percent_apr = $this->apr / 100;
            $daily_interest_rate = $percent_apr / 365;
            $daily_interest = $this->amount * $daily_interest_rate;
            $total_reward = $daily_interest * $this->radioDuration;

            $this->earnings = round($total_reward, PHP_ROUND_HALF_UP, 3);
            $this->futureDate = Carbon::now()->addDays($this->radioDuration)->format('d-m-Y');
            $this->step = 2;
            $this->isButtonDisabled = $this->confirmStake();
        }
    }


    public function confirmStake()
    {
        return $this->step !== 1 || !$this->radioDuration || $this->amount <= 0;
    }


    public function mount()
    {
        $this->amount;
        $this->earnings;
        $this->apr;
        $this->futureDate;
    }


    public function selectPercentage($percentage)
    {
        $this->selectedPercentage = $percentage;
        $this->amount = ($percentage / 100) * $this->availableBalance;
    }

    public function selectAPR($selectedapr)
    {
        $this->apr = $selectedapr;
    }

    public function createStake()
    {
        $validatedData = $this->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:' . $this->availableBalance],
            'radioDuration' => ['required', 'numeric'],
        ]);

        $duration    = Carbon::now();
        $nextHalving = Carbon::now();

        $duration->addDays($this->radioDuration);
        $nextHalving->addDay();


        $createStake = Purchase::create([
            'user_id' => auth()->user()->user_id,
            'plan_name' => $this->coindata->coin_name,
            'plan_id' => $this->coindata->id,
            'purchase_id' => unik(),
            'amount' => $validatedData['amount'],
            'duration' => $duration,
            'total_profit' => $this->earnings,
            'apr' => $this->apr,
            'current_profit' => 0,
            'type' => 'staking',
            'return_type' => 'days',
            'original_hour' => $this->radioDuration,
            'progress_counter' => 0,
            'initial_hour' => $this->radioDuration,
            'next_halving' => $nextHalving,
            'status' => 'active',
        ]);

        if ($createStake) {
            //$user = User::findOrFail(auth()->user()->id);
            $this->walletInfo->amount -= $validatedData['amount'];
            $this->walletInfo->save();
            $this->step = 0;
        }

        $isSuccess = true;
        $responseMsg = 'You have successfully staked ' . $validatedData['amount'] . ' ' . custom_str_replace($this->coindata->coin_name, '-', ' ', 'upper') . ' for ' . $this->radioDuration . ' days';
        $this->dispatchBrowserEvent('hide-purchaseForm', ['check' => $isSuccess, 'message' => $responseMsg]);
    }
}
