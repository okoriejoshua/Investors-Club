<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\User\UserComponent;
use App\Models\Stakewallet;
use App\Models\Transaction;
use App\Models\Payaddress;
use App\Models\Usersettings;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\validator;

class Withdraw extends UserComponent
{
    public $step = 0;
    public $paycoins = null;
    public $scoin = null;
    public $cancelID = null;
    public $payAddresses = null;
    public $selected = null;
    public $state = [];
    public $amountInput = 0;
    public $destination = null;
    public $wpin = null;
    public $usewpin = false;
    public $usersetting = null;

    public function render()
    {

        $this->paycoins    = Stakewallet::where('user_id', auth()->user()->id)->latest()->get();
        $this->usersetting = Usersettings::where('user_id', auth()->user()->id)->where('is_wpin', true)->first();
        $this->usewpin     = $this->usersetting ? true:false; 

        if (isset($this->state['networkid'])) {
            $x = explode('-', $this->state['networkid']);
            $this->selected = $this->paycoins->where('coin', $x[0])->first();
        } 
        

        $this->amountInput = isset($this->state['amount']) ? $this->state['amount'] : $this->amountInput;
        $this->destination = isset($this->state['destination']) ? $this->state['destination'] : $this->destination;
        
        return view('livewire.user.withdraw', [
            'paycoins'    => $this->paycoins,
            'addresses'   => $this->payAddresses,
            'selected'    => $this->selected,
            'amountinput' => $this->amountInput,
            'destination' => $this->destination,
            'usewpin'     => $this->usewpin,
            'wpin'        => $this->wpin,
            'step'        => $this->step,
        ])->layout('layouts.user');
    }

    public function mount()
    {
        $this->amountInput = 0;

        if (!isset($this->state['amount']) || $this->selected === null || $this->selected->amount === null) {
            return;
        }

        if ($this->state['amount'] > $this->selected->amount) {
            $this->amountInput = 0;
        }
    }

    public function checkPin()
    {
         
        if (isset($this->wpin)) {
            if (Hash::check($this->wpin, $this->usersetting->wpin)) {
                $this->step =  2;
                $this->usewpin = false;
                $this->dispatchBrowserEvent('hide-wpinform',['status'=>true,'message'=>'verified successfully']);
            }else{
                $this->dispatchBrowserEvent('hide-wpinform', ['status' => false, 'message' => 'Incorrect PIN']);
            }

            
        }
        
    }

    public function showPINmodal()
    {
        $this->dispatchBrowserEvent('show-wpin_modal');
    }

    public function Steps($step)
    {
        $this->step =  $step;
        $this->step == 0 ? $this->reset() : '';
        $this->step == 2 ? $this->dispatchBrowserEvent('show-confirmation-modal') : '';
    }

    public function maxBal()
    {
        $this->state['amount'] = $this->selected->amount;
    }

    public function selectCoin()
    {
        $this->payAddresses = Payaddress::query()
            ->where('coin_name', $this->state['asset'])
            ->where('status', true)
            ->latest()->get();
        $this->step = 1;
        $this->scoin = $this->state['asset'];
    }

    public function saveWithdraw()
    {
        $validatedData = validator::make($this->state, [
            'asset' => 'required',
            'amount' => 'required|numeric|max:' . $this->selected->amount,
            'networkid' => 'required',
            'destination' => 'required',
        ])->validate();


        $withdrawData = [];
        $withdrawData['from_id']     = auth()->user()->user_id;
        $withdrawData['type']        = 'withdraw';
        $withdrawData['amount']      = $validatedData['amount'];
        $withdrawData['asset']       = $validatedData['asset'];
        $withdrawData['destination'] = $validatedData['destination'];
        $withdrawData['network']     = explode('-', $this->state['networkid'])[1];
        $withdrawData['transaction_id'] = unik();
        $withdrawData['steps']       = 2;
        $withdrawData['paymethod']   = 'crypto';
        $withdrawData['pop']   = 'none';

        Transaction::create($withdrawData);
        $this->selected->amount -= $validatedData['amount'];
        $this->selected->save();
        $this->step = 0;
        $this->reset();
        $this->dispatchBrowserEvent('show-modal-success');
        
        // testing Transaction::whereNull('pop')->update(['pop' => 'none']);
    }
}
