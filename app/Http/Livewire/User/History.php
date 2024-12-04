<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\User\UserComponent;
use App\Models\Transaction;

class History extends UserComponent
{
    public $transactions = null;
    public $category =null;
    public $pendings = null;
    public $details = null;
    public $tab = 'list';
    public $perPage = 10;
    public $step = 0;

    public function render()
    {
        
        $query = Transaction::query()
        ->where(function ($query) {
            $query->where('from_id', auth()->user()->user_id)
            ->orWhere('to_id', auth()->user()->user_id);
        })
        ->where(function ($query) {
            $query->where('type', '!=', 'deposit')
                ->orWhere('pop', '!=', null);
        })
        ->orderBy('created_at', 'desc');

        if ($this->category && $this->category!='all') {
            $query->where('type', $this->category);
        }

        if ($this->tab == 'list') {
            $query->where('status', '<>', 'pending');
        }

        $this->transactions = $query->offset(($this->page - 1) * $this->perPage)
        ->limit($this->perPage)
        ->get();
         
        $this->pendings = $this->transactions->where('status', 'pending'); 

        if ($this->category == null) {
            $this->category='all';
        }
        return view(
            'livewire.user.history',
            [
                'transactions' => $this->transactions,
                'category' => $this->category,
                'pendings' => $this->pendings,
                'details' => $this->details,
                'tab' => $this->tab, 
            ]
        )->layout('layouts.user');
    }

    public function loadMore()
    {
        $this->page++;
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
    }

    public function getDetails($id)
    {
        $this->details = $this->transactions->where('id', $id)->first();
        $this->open('history-details');
    }

    public function changeCategory($category)
    {
        $this->category = $category;
    }
    
}
