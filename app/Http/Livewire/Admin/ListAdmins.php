<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Http\Livewire\Admin\AdminComponent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\validator;

class ListAdmins extends AdminComponent
{
 
  public $status = null;
  public $state = [];
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
      'role' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|confirmed',
    ])->validate();

    //user type
    $validatedData['type'] = 'admin';
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
      'role' => 'sometimes',
    ])->validate();

    if (!empty($validatedData['password'])) {
      $validatedData['password'] = Hash::make($validatedData['password']);
    }
    $this->user->update($validatedData);
    $this->dispatchBrowserEvent('hide-form', ['message' => 'User Details Updated Successfully!']);
  }


  public function suspendUser()
  {
    $user = User::findOrFail($this->selectedUserId);
    $user->status = $user->status == 'active' ? 'suspended' : 'active';
    $user->save();
    $state = $user->status == 'active' ? 'Activated' : 'Suspended';
    $this->dispatchBrowserEvent('hide-suspendModal', ['message' => 'User Account ' . $state . ' Successfully!']);
  }

  public function render()
  {
   
    $admins = User::query()
    ->where('type', 'admin')
    ->where('id', '<>', auth()->id())
    ->where(function ($query) {
      $query->where('name', 'like', '%' . $this->searchQuery . '%')
        ->orWhere('email', 'like', '%' . $this->searchQuery . '%');
    })
      ->latest()
      ->paginate(15);
    return view('livewire.admin.list-admins', ['admins' => $admins])
      ->layout('layouts.admin');
  }
}
