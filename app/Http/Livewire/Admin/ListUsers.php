<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Http\Livewire\Admin\AdminComponent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\validator;

class ListUsers extends AdminComponent
{

    public $status = null;
    public $state = [];
    public $profileData = [];
    public $showEditModal =  false;
    public $user;
    public $selectedUserId = null;
    public $searchQuery = null;


    public function addModal()
    {
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function editModal(User $user)
    {
        $this->showEditModal = true;
        $this->user = $user;
        $this->selectedUserId = $this->user->id;
        $this->state = $user->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function confirmSuspendModal($userId)
    {
        $this->selectedUserId = $userId;
        $user = User::findOrFail($this->selectedUserId);
        $this->status  = $user->status == 'active' ? true : false;
        $this->dispatchBrowserEvent('show-suspendModal');
    }

    public function profileModal($userId)
    {
        $this->selectedUserId = $userId;
        $this->profileData  = User::findOrFail($this->selectedUserId);
        $this->dispatchBrowserEvent('show-profileModal');
    }

    public function fundUserModal(User $user)
    {
        $this->user = $user;
        $this->selectedUserId = $this->user->id;
        $this->state = $user->toArray();
        $this->dispatchBrowserEvent('show-addFundModal');
    }

    public function generatePassword()
    {
        $this->state['password'] = '';
        $this->state['password_confirmation'] = '';
        $characters = '@#$%^&*()!0123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';
        for ($i = 0; $i < 10; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $this->state['password'] .= $characters[$randomIndex];
            $this->state['password_confirmation'] .= $characters[$randomIndex];
        }
    }



    public function createUser()
    {
        $validatedData = validator::make($this->state, [
            'name' => 'required',
            'bal' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ])->validate();


        $validatedData['type'] = 'user';
        $validatedData['user_id'] = uniqid();
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'New User Successfully Created!']);
    }

    public function updateUser()
    {
        $validatedData = validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'sometimes|confirmed',
            'bal' => 'sometimes|numeric',
        ])->validate();

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        $this->user->update($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'User Details Updated Successfully!']);
    }

    public function saveFund()
    {
        $validatedData = validator::make($this->state, [
            'fdestination' => 'required',
            'id' => 'required|unique:users,id,' . $this->user->id,
            'amount' => 'required|numeric',
        ])->validate();

        $user = User::findOrFail($this->user->id);
        $user[$validatedData['fdestination']] += $validatedData['amount'];
        $user->save();
        //re -render profileModal
        $this->profileData = User::findOrFail($this->selectedUserId);
        $this->dispatchBrowserEvent('hide-addfundModal', ['message' => 'User Account Funded Successfully!']);
    }


    public function suspendUser()
    {
        $user = User::findOrFail($this->selectedUserId);
        $user->status = $user->status == 'active' ? 'suspended' : 'active';
        $user->save();
        $state = $user->status == 'active' ? 'Activated' : 'Suspended';
        $this->dispatchBrowserEvent('hide-suspendModal', ['message' => 'User Account ' . $state . ' Successfully!']);
    }

    /*public function deleteUser()
    {
        $user = User::findOrFail($this->deletableUserId);
        $user->delete();
        $this->dispatchBrowserEvent('hide-deleteModal', ['message' => 'User Deleted Successfully!']);
    } */

    public function render()
    {

        $users = User::query()
            ->where('type', 'user')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%')
                    ->orWhere('email', 'like', '%' . $this->searchQuery . '%');
            })
            ->latest()
            ->paginate(15);

        foreach ($users as $user) {
            $user->date_joined  = $user->created_at->format('d-m-y');
        }
        return view('livewire.admin.list-users', ['users' => $users])
            ->layout('layouts.admin');
    }
}
