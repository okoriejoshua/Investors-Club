<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Deposits extends Component
{
    public function render()
    {
        return view('livewire.admin.deposits')->layout('layouts.admin');
    }
}
