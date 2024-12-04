<?php

namespace App\Http\Livewire\User;

use App\Models\Usersettings;
use App\Models\KYCData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Http\Livewire\User\UserComponent;

class Settings extends UserComponent
{
    use WithFileUploads;
    public $isWP = false;
    public $is2FA = false;
    public $isLock = false;
    public $userSetting;
    public $kycdata;
    public $showEditModal =  false;
    public $isKyced =  false;
    public $state = [];

    public $cardfront;
    public $cardback;
    public $step = 1;

    public function is_WP()
    {
        if ($this->userSetting) {
            $this->userSetting->is_wpin = $this->isWP;
            $this->userSetting->save();
        } else {
            $this->userSetting = Usersettings::create([
                'user_id' => auth()->user()->id,
                'is_wpin' => $this->isWP,
            ]);
        }
    }

    public function is_2FA()
    {
        if ($this->userSetting) {
            $this->userSetting->is_2fa = $this->is2FA;
            $this->userSetting->save();
        } else {
            $this->userSetting = Usersettings::create([
                'user_id' => auth()->user()->id,
                'is_2fa' => $this->is2FA,
            ]);
        }
    }
    public function is_Lock()
    {
        if ($this->userSetting) {
            $this->userSetting->is_lock = $this->isLock;
            $this->userSetting->save();
        } else {
            $this->userSetting = Usersettings::create([
                'user_id' => auth()->user()->id,
                'is_lock' => $this->isLock,
            ]);
        }
    }

    public function openWpinModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('show-wpin_modal');
    }


    public function updateWpin()
    {

        $validatedData = validator::make($this->state, [
            'current_wpin' => 'required',
            'wpin' => 'required|min:4|confirmed',
        ])->validate();

        if (Hash::check($validatedData['current_wpin'], $this->userSetting->wpin)) {
            $this->userSetting->fill([
                'wpin' => Hash::make($validatedData['wpin']),
            ])->save();

            $isSuccess = true;
            $responseMsg = 'PIN Updated Successfully!';
        } else {
            $isSuccess = false;
            $responseMsg = 'The provided current PIN does not match your existing PIN';
        }
        $this->dispatchBrowserEvent('hide-wpinform', ['status' => $isSuccess, 'message' => $responseMsg]);
    }

    public function createWpin()
    {
        $validatedData = validator::make($this->state, [
            'wpin' => 'required|min:4|confirmed',
        ])->validate();

        $hashedwpin = Hash::make($validatedData['wpin']);

        if ($this->userSetting) {
            $this->userSetting->wpin = $hashedwpin;
            $this->userSetting->save();
        } else {
            $this->userSetting = Usersettings::create([
                'user_id' => auth()->user()->id,
                'wpin' => $hashedwpin,
            ]);
        }
        $this->dispatchBrowserEvent('hide-wpinform', ['status' => true, 'message' => 'Withdrawal PIN Created Successfully!']);
    }

    public function render()
    {
        $this->userSetting = Usersettings::where('user_id', auth()->user()->id)->first();
        if ($this->userSetting) {
            $this->isWP = $this->userSetting->is_wpin;
            $this->is2FA = $this->userSetting->is_2fa;
            $this->isLock = $this->userSetting->is_lock;
            $this->userSetting->wpin == NULL ? $this->showEditModal : $this->showEditModal =  true;
        }

        $this->kycdata = KYCData::where('user_id', auth()->user()->id)->first();
        if ($this->kycdata) {
            $this->step = $this->kycdata->steps;
            $this->isKyced =  true;
        }

        return view('livewire.user.settings', [
            'settings' => $this->userSetting,
            'kycdata' => $this->kycdata,
            'step' => $this->step,
        ])->layout('layouts.user');
    }



    public function openKYCModal()
    {
        $this->dispatchBrowserEvent('show-kyc_modal');
    }


    public function KYCDataSubmit()
    {
        $validatedData = validator::make($this->state, [
            'card_type' => 'required',
            'name_on_card' => 'required',
            'country_issued' => 'required',
            'expiry' => 'sometimes',
            'serial_number' => 'sometimes|numeric',
        ])->validate();


        if ($this->kycdata) {
            $validatedData['expiry']        = isset($validatedData['expiry']) ? $validatedData['expiry'] : null;
            $validatedData['serial_number'] = isset($validatedData['serial_number']) ? $validatedData['serial_number'] : null;

            $this->kycdata->card_type      = $validatedData['card_type'];
            $this->kycdata->name_on_card   = $validatedData['name_on_card'];
            $this->kycdata->country_issued = $validatedData['country_issued'];
            $this->kycdata->expiry = $validatedData['expiry'];
            $this->kycdata->serial_number = $validatedData['serial_number'];
            $this->kycdata->steps = 2;
            $this->kycdata->save();
        } else {
            $validatedData['user_id'] = auth()->user()->id;
            $validatedData['steps'] = 2;
            $this->kycdata = KYCData::create($validatedData);
        }
        
    }

    public function UploadKYC()
    {

        $cardfront = $this->kycdata->user_id. '_kyc_' .$this->kycdata->card_type.'_front'. '.png';
        $cardback  = $this->kycdata->user_id . '_kyc_' . $this->kycdata->card_type . '_back' . '.png';

        $this->validate(['cardfront' => 'required|image|max:1024', 'cardback' => 'required|image|max:1024',]);

        Storage::disk('kyc')->delete([$this->kycdata->card_front, $this->kycdata->card_back]);
        
         $this->cardfront->storeAs('/', $cardfront, 'kyc');
         $this->cardback->storeAs('/', $cardback, 'kyc');

         $this->kycdata->fill([
             'card_front' => $cardfront,
             'card_back' => $cardback,
             'status' => 'pending',
             'steps'=>3,
             ])->save();

        $this->dispatchBrowserEvent('kyc-upload-status', ['message' => 'KYC DATA Submited for Verification']);
        $this->reset(); 
    }

}
