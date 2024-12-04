<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\validator;
use Livewire\WithFileUploads;

class ViewProfile extends Component
{
    use WithFileUploads;
    public $state = [];
    public $ud;
    public $photo;

    public function openChangePhotoTab($userdata)
    {
        //$this->ud = $ud;
        $userdata  = User::findOrFail(auth()->user()->id);
        $this->state = $userdata->toArray();
        $this->dispatchBrowserEvent('show-change-photo-form');
    }

    public function updateProfileInfo()
    {
        $validatedData = validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->ud->id,
            'phone' => 'required|numeric',
        ])->validate();
        
        $this->ud->update($validatedData);
        $profile_name = $validatedData['name'];
        $this->dispatchBrowserEvent('form-response-profile-update', ['profile_name' => $profile_name, 'message' => 'User Details Updated Successfully!']);
    }

    public function savePhoto()
    {
    
        $renamed = $this->ud->id.'-'.time().'.png';
        $validatedData = $this->validate(['photo' => 'image|max:1024',]);

        Storage::disk('photos')->delete($this->ud->photo);
        $validatedData['photo'] = $this->photo->storeAs('/', $renamed,'photos');
        $this->ud->fill(['photo' => $renamed,])->save();

        $newPhotoUrl = asset('storage/photos/' . $renamed);
        $this->reset();
        $this->dispatchBrowserEvent('form-response-photo-update', ['photo_url'=> $newPhotoUrl, 'message' => 'Photo Uploaded Successfully!']);
    }


    public function updatePassword()
    {
        $validatedData = validator::make($this->state, [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ])->validate();

        if (Hash::check($validatedData['current_password'], $this->ud->password)) {
            $this->ud->fill([
                'password' => Hash::make($validatedData['password']),
            ])->save();

            $isSuccess = true;
            $responseMsg = 'User Pasword Updated Successfully!';
        } else {
            $isSuccess = false;
            $responseMsg = 'The provided old password does not match your current password';
        }

        $this->dispatchBrowserEvent('form-response-password', ['status' => $isSuccess, 'message' => $responseMsg]);
    } 

    public function render()
    {
        $user  = User::findOrFail(auth()->user()->id);
        $this->ud = $user;
        $this->state = $user->toArray();
        return view('livewire.admin.view-profile', ['ud' => $this->ud])->layout('layouts.admin');
    }
}
