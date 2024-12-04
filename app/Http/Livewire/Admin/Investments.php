<?php

namespace App\Http\Livewire\Admin;


use App\Models\Investment;
use App\Models\Planstype;
use App\Http\Livewire\Admin\AdminComponent;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Investments extends AdminComponent
{
    use WithFileUploads;
    public $status = null;
    public $state = [];
    public $showEditModal =  false;
    public $investment;
    public $selectedinvestmentId = null;
    public $searchQuery = null;
    public $photo;


    public function slugify($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $title)));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = str_replace('\'', '-', $slug); 
        return $slug;
    }

    public function addModal()
    {
       
        $this->state = [];
        $this->showEditModal = false;
        $this->reset();
        $this->dispatchBrowserEvent('show-form');
    }

    public function editModal(Investment $investment)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->investment = $investment;
        $this->selectedinvestmentId = $this->investment->id;
        $this->state = $investment->toArray();
        
        $this->dispatchBrowserEvent('show-form');
    }

    public function confirmSuspendModal($investmentId)
    {
        $this->selectedinvestmentId = $investmentId;
        $investment = Investment::findOrFail($this->selectedinvestmentId);
        $this->status  = $investment->status == 'active' ? true : false;
        $this->dispatchBrowserEvent('show-suspendModal');
    }

    public function deleteModal($investmentId)
    {
        $this->selectedinvestmentId = $investmentId;
        $investment = Investment::findOrFail($this->selectedinvestmentId);
        $this->status  = $investment->status == 'active' ? true : false;
        $this->dispatchBrowserEvent('show-deleteModal');
    }

    public function createInvestment()
    {
        $validatedData = validator::make($this->state, [
            'name' => 'required',
            'category' => 'required',
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric',
            'profit' => 'required|numeric',
            'return_type' => 'required',
            'numdays' => 'required|numeric',
            'counts' => 'required|numeric',
            'photo' => 'image|max:1024',
        ])->validate();

        $validatedData['slug'] = $this->slugify($validatedData['name']);
        if($this->photo){
        $renamed = str_replace(' ','-', $this->slugify($validatedData['name'])). '-' . time() . '.png';
        $validatedData['photo'] = $this->photo->storeAs('/', $renamed, 'investments');
        }

        Investment::create($validatedData);
        $this->reset();
        $this->dispatchBrowserEvent('hide-form', ['message' => 'New investment Successfully Created!']);
    }

    public function updateInvestment()
    {

        $validatedData = validator::make($this->state, [
            'name' => 'required',
            'category' => 'required',
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric',
            'profit' => 'required|numeric',
            'return_type' => 'required',
            'numdays' => 'required|numeric',
            'counts' => 'required|numeric',
        ])->validate();

       
        if ($this->photo) {
            Storage::disk('investments')->delete($this->investment->photo); 
            $renamed = str_replace(' ', '-', $this->slugify($validatedData['name'])) . '-' . time() . '.png';
            $validatedData['photo'] = $this->photo->storeAs('/', $renamed, 'investments');
        }
        $validatedData['slug'] = $this->slugify($validatedData['name']);
        $this->investment->update($validatedData);
        $this->dispatchBrowserEvent('hide-form', ['message' => 'Investment Details Updated Successfully!']);
    }

    


    public function suspendInvestment()
    {
        $investment = Investment::findOrFail($this->selectedinvestmentId);
        $investment->status = $investment->status == 'active' ? 'suspended' : 'active';
        $investment->save();
        $state = $investment->status == 'active' ? 'Activated' : 'Suspended';
        $this->dispatchBrowserEvent('hide-suspendModal', ['message' => 'investment Plan ' . $state . ' Successfully!']);
    }

    public function deleteInvestment()
    {
        $investment = investment::findOrFail($this->selectedinvestmentId);
        $investment->delete();
        $this->dispatchBrowserEvent('hide-deleteModal', ['message' => 'Investment Deleted Successfully!']);
    } 

    public function render()
    {

        $investments = Investment::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('category', 'like', '%' . $this->searchQuery . '%');
            })->latest()->paginate(15);

        $categories = Planstype::query()->where('status', 'active')->latest()->get(); 
        return view('livewire.admin.investments', compact('investments', 'categories'))->layout('layouts.admin');
    }
    
}
