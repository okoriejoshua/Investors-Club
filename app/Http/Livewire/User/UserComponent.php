<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;
    protected $paginationTheme ='bootstrap';

    public $modalid=null;
    public $step = 0;

    public $isDarkMode = true;
    
    public function close($modalid)
    {
        $this->modalid = $modalid;
        $this->dispatchBrowserEvent('close-modal',['modalid' => $this->modalid]);
    }

    public function open($modalid)
    {
        $this->modalid = $modalid;
        $this->dispatchBrowserEvent('open-modal', ['modalid' => $this->modalid]);
    }

    public function goto($url)
    {
        $this->redirect($url);
    }

    public function goBack()
    {
       //if ($this->canGoBack()) {
         $this->emit('goBack');
       //}
    }


    public function backStep()
    {
       $this->step  -= 1;
    }

    public function mount()
    {
        $this->isDarkMode = session()->get('isDarkMode', false);
    }

    public function toggleDarkMode()
    {
        $this->isDarkMode = !$this->isDarkMode;
        session()->put('isDarkMode', $this->isDarkMode);
    }


}