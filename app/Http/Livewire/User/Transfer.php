<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\User\UserComponent;
use App\Models\Stakewallet;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Payaddress;
use App\Models\Usersettings;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\validator;

class Transfer extends UserComponent
{
    public $step = 0;
    public $paycoins = null;
    public $person = null;
    public $selected = null;
    public $state = [];
    public $amountInput = 0;
    public $destination = null;
    public $wpin = null;
    public $usewpin = false;
    public $usersetting = null;
    public $isfound = false;


    public function render()
    {
        $this->paycoins    = Stakewallet::where('user_id', auth()->user()->id)->latest()->get();

        $this->usersetting = Usersettings::where('user_id', auth()->user()->id)->where('is_wpin', true)->first();
        $this->usewpin     = $this->usersetting ? true : false;

        if (isset($this->state['asset'])) {
            $this->selected = $this->paycoins->where('coin', $this->state['asset'])->first();
        }
        return view('livewire.user.transfer', [
            'person' => $this->person,
            'isfound' => $this->isfound,
            'selected'    => $this->selected,
            'paycoins'    => $this->paycoins,
            'step'    => $this->step,
        ])->layout('layouts.user');
    }

    public function findUser()
    {
        if (isset($this->state['person'])) {
            $Query = User::query()
                ->where('type', 'user')
                ->where('id', '<>', auth()->user()->id)
                ->where(function ($query) {
                    $query->where('user_id', $this->state['person'])
                        ->orWhere('email', $this->state['person']);
                })
                ->first();

            if ($Query) {
                $this->person = $Query;
            } else {
                $this->isfound = 'nothing';
            }
        }
    }

    public function checkPin()
    {

        if (isset($this->wpin)) {
            if (Hash::check($this->wpin, $this->usersetting->wpin)) {
                $this->step =  3;
                $this->usewpin = false;
                $this->dispatchBrowserEvent('hide-wpinform', ['status' => true, 'message' => 'verified successfully']);
            } else {
                $this->dispatchBrowserEvent('hide-wpinform', ['status' => false, 'message' => 'Incorrect PIN']);
            }
        }
    }

    public function maxBal()
    {
        $this->state['amount'] = $this->selected->amount;
    }

    public function showPINmodal()
    {
        if (!isset($this->state['amount'])) {
            return;
        } elseif ($this->state['amount'] == 0) {
            return;
        } elseif ($this->state['amount'] > $this->selected->amount) {
            return;
        } else {
            $this->dispatchBrowserEvent('show-wpin_modal');
        }
    }

    public function Steps($step)
    {
        $this->step  =  $step;
    }

    public function makeTransfer()
    {
        $validatedData = validator::make($this->state, [
            'asset' => 'required',
            'amount' => 'required|numeric|max:' . $this->selected->amount,
            'person' => 'required',
        ])->validate();


        $withdrawData = [];
        $withdrawData['from_id']     = auth()->user()->user_id;
        $withdrawData['to_id']       = $this->person->user_id;
        $withdrawData['type']        = 'transfer';
        $withdrawData['status']        = 'successful';
        $withdrawData['amount']      = $validatedData['amount'];
        $withdrawData['asset']       = $validatedData['asset'];
        $withdrawData['destination'] = $this->person->user_id;
        $withdrawData['network']     = $validatedData['asset'];
        $withdrawData['transaction_id'] = unik();
        $withdrawData['steps']       = 3;
        $withdrawData['paymethod']   = 'crypto';
        $withdrawData['pop']   = 'none';

        $isSaved = Transaction::create($withdrawData);
        $this->selected->amount -= $validatedData['amount'];
        $this->selected->save();

        $credituser    = Stakewallet::where('user_id', $this->person->id)->where('coin', $validatedData['asset'])->first();
        if ($credituser) {
            $credituser->amount += $validatedData['amount'];
            $credituser->save();
        }else{
            Stakewallet::create([
                'user_id'=> $this->person->id,
                'coin' => $validatedData['asset'],
                'amount' => $validatedData['amount'],
                'status' => 'open',
                'coinvalue' =>0,
                'profit' =>0,
            ]);

        }
        
        $this->dispatchBrowserEvent('show-modal-success');
        $this->step = 0;
        $this->reset();
    }
}
