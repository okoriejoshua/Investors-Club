<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\User\UserComponent;
use App\Models\Transaction;
use App\Models\Paycoin;
use App\Models\Payaddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\validator;


class Deposits extends UserComponent
{
    use WithFileUploads;
    public $step = 0;
    public $paycoins = null;
    public $scoin = null;
    public $cancelID = null;
    public $payAddresses =null;
    public $getAddress = null;
    public $transaction = null;
    public $state = [];
    public $pop;


    public function render()
    {
        $this->paycoins = Paycoin::where('deposit',true)->where('status',true)->latest()->get();

        if(isset($this->state['networkid'])){

            $this->getAddress = $this->payAddresses->where('id', $this->state['networkid'])->first();
            $address = isset($this->getAddress->address)? $this->getAddress->address: null;
            $today = Carbon::now();
            $this->transaction = Transaction::where('from_id', auth()->user()->user_id)
            ->where('asset', $this->scoin)
            ->where('destination', $address)
            ->where('pop', NULL)
            ->where('created_at','<>',$today)->first();

            if ($this->transaction) {
                $this->state = $this->transaction->toArray();
                $this->step == 3 ? $this->dispatchBrowserEvent('hide-exist-modal') : $this->dispatchBrowserEvent('show-deposit-exist-modal');
            } 
        }
        
        return view('livewire.user.deposits', [
            'paycoins' => $this->paycoins,
            'addresses' => $this->payAddresses,
            'destination' => $this->getAddress,
            'transaction' => $this->transaction,
            'scoin' => $this->scoin,
            'step' => $this->step,
        ])->layout('layouts.user');
    }

    public function Steps($step)
    {
        $this->step = $step;
        $this->step == 3 ? $this->dispatchBrowserEvent('hide-exist-modal'):'';

    }

    public function Cancel($id)
    {
        $this->cancelID =$id;
        $this->transaction->delete($this->cancelID);
        $this->dispatchBrowserEvent('hide-exist-modal');
        $this->Steps(2);

    }

    public function selectCoin()
    {
        $this->payAddresses = Payaddress::query()
            ->where('coin_name', $this->state['asset'])
            ->where('status', true)
            ->latest()->get();
        $this->step = 2;
        $this->scoin = $this->state['asset'];
    }

    public function saveDeposit()
    {
        $validatedData = validator::make($this->state, [
            'asset' => 'required',
            'amount' => 'required',
            'networkid' =>'required',
        ])->validate();

        $depositData=[];
        $depositData['from_id']     = auth()->user()->user_id;
        $depositData['type']        = 'deposit';
        $depositData['amount']      = $validatedData['amount'];
        $depositData['asset']       = $validatedData['asset'];
        $depositData['destination'] = $this->getAddress->address;
        $depositData['network']     = $this->getAddress->network;
        $depositData['transaction_id'] = unik();
        $depositData['steps']       = 3;
        $depositData['paymethod']   = 'crypto';
        
        $this->transaction = Transaction::create($depositData);
        $this->step = 3;
        $this->dispatchBrowserEvent('show-deposit-modal');
    }
 
    public function uploadPOP()
    {

        $popname =  $this->transaction->from_id. '_' . $this->transaction->transaction_id. '_pop' . '.png';
       
        $validatedData = $this->validate(['pop' => 'required|image|max:1024']);
        Storage::disk('pops')->delete([$this->transaction->pop]);
        $validatedData['pop']->storeAs('/', $popname, 'pops'); 
        $this->transaction->fill([
            'pop' => $popname,
            'steps' => 4,
        ])->save();

        $this->dispatchBrowserEvent('upload-saved', ['message' => 'POP Sent for Verification']);
        $this->reset();
    }
         
}

