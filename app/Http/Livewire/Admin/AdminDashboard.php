<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Admin\AdminComponent;

class AdminDashboard extends AdminComponent
{
    public function render()
    {
        return view('livewire.admin.admin-dashboard')->layout('layouts.admin');
    }
}
