<div>
    <x-loading-indicator-targeted />
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item btn-small"><span class="goback"><i class="right fas fa-angle-left"></i></span></li>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><button wire:loading.attr="disabled" wire:click.prevent="addModal" class="btn  btn-primary ">
                            <i class="fas fa-plus-circle"></i> Add New</button></li>
                </ol>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Investments</h3>
                            <div class="card-tools">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="input-group input-group-sm border border-light rounded" style="width: 150px;">
                                        <input wire:model="searchQuery" type="text" name="table_search" class="border-0 form-control float-left" placeholder="Search">
                                        <x-small-spinner condition="delay" target="searchQuery" class="mt-1 pr-1" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Thumbnail</th>
                                        <th>Name</th>
                                        <th>Mini-price</th>
                                        <th>ROI</th>
                                        <th>Duration</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted" wire:target="searchQuery">
                                    @forelse ($investments as $investment)
                                    <tr>
                                        <td>{{ $loop->iteration  }}</td>
                                        <td>
                                            <img src="{{ $investment->photo ? asset('storage/investments/'.$investment->photo): asset('storage/photos/noimage.jpg') }}" style="width:40px; border-radius:4px;" alt="Thumbnail">
                                        </td>
                                        <td>{{ $investment->name  }}</td>
                                        <td>{{ $investment->min_price  }}</td>
                                        <td>{{ $investment->profit  }} %</td>
                                        <td>{{ $investment->numdays  }} {{ $investment->return_type  }}</td>

                                        <td>
                                            <span wire:click.prevent="editModal({{ $investment }})" class="badge bg-success p-2"><i class="fas fa-pen"></i> Edit</span>
                                            <span wire:click.prevent="confirmSuspendModal({{ $investment->id  }})" class="badge {{ ($investment->status =='active')? ' bg-warning ':'  bg-primary '  }} p-2"><i class="fas fa-spinner"></i> {{ ($investment->status =='active')? 'Suspend':' Activate'  }}</span>
                                            <span wire:click.prevent="deleteModal({{ $investment->id }})" class="badge bg-danger p-2"><i class="fas fa-trash"></i> Delete</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="text-center">
                                        <td colspan="5">No result found!</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end">{{ $investments->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="addForm" wire:ignore.self style="padding-left: 0px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        @if($showEditModal) <span>Edit Investment </span> @else <span>Add New Investment </span> @endif
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" autocomplete="off" wire:submit.prevent="{{$showEditModal?'updateInvestment':'createInvestment'}}">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <label for="planname" class="col-form-label">Investment Name</label>
                                <label for="category" class="col-form-label">Category </label>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="text" wire:model.defer="state.name" class="form-control  @error('name') is-invalid @enderror" id="planname" placeholder="investment name">
                                        @error('name')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>&nbsp;
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <select id="category" wire:model.defer="state.category" class="custom-select @error('category') is-invalid @enderror ">
                                            <option selected>-- Select Category --</option>
                                            @foreach ($categories as $category )
                                            <option value="{{$category->slug}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label for="minprice" class="col-form-label">Min Price</label>
                                <label for="maxprice" class="col-form-label">Max Price</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="number" wire:model.defer="state.min_price" class="form-control  @error('min_price') is-invalid @enderror" id="minprice" placeholder=" Minimum Price">
                                        @error('min_price')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>&nbsp;
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="number" wire:model.defer="state.max_price" class="form-control  @error('max_price') is-invalid @enderror" id="maxprice" placeholder=" Maxmum Price">
                                        @error('max_price')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <label for="return_type" class="col-form-label">Return Profit</label>
                                <label for="numdays" class="col-form-label">Duration </label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <select id="return_type" wire:model.defer="state.return_type" class="custom-select @error('return_type') is-invalid @enderror ">
                                            <option selected> --Select-- </option>
                                            <option value="hours">Return Profit Hourly </option>
                                            <option value="days">Return Profit Daily </option>
                                        </select>
                                        @error('return_type')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>&nbsp;
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="number" wire:model.defer="state.numdays" class="form-control  @error('numdays') is-invalid @enderror" id="numdays" placeholder=" num of days/hrs">
                                        @error('numdays')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <label for="profit" class="col-form-label pull-left">% Profit</label>
                                <label for="maxprice" class="col-form-label pull-right">Buy Limits
                                </label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="text" wire:model.defer="state.profit" class="form-control  @error('profit') is-invalid @enderror" id="profit" placeholder=" Percentage Profit. eg 35">
                                        @error('profit')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>&nbsp;
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="number" wire:model.defer="state.counts" class="form-control  @error('counts') is-invalid @enderror" id="counts" placeholder="2 or 3 , 5 etc">
                                        @error('counts')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                        <small class="text-warning row">A user can buy at Once</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div x-data="{ isUploading:false, progress:3 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false; progress=3 "
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                                    <label for="photo">Choose Thumbnail [<small class="text-warning">less than 500kb</small>]</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input wire:model="photo" type="file" class="custom-file-input" id="photo">
                                        </div>
                                        <div class="input-group-append">
                                            <label class="custom-file-label" for="photo">{{$photo?$photo->getClientOriginalName():'Choose file'}}</label>
                                        </div>
                                    </div>
                                    <div x-show="isUploading" class="progress progress-xs ">
                                        <div :style="`width: ${progress}%`" class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                            aria-valuenow="3" aria-valuemin="0" aria-valuemax="100">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>

                                @if($photo)
                                <img src="{{$photo->temporaryUrl()}}" style="width:100%;border-radius:4px;" class="mt-2 text-center d-block" alt="Thumbnail">
                                @else
                                @isset($state['photo'])
                                <img src="{{ asset('storage/investments/'.$state['photo'])}}" style="width:100%; border-radius:4px;" class="mt-2 text-center d-block" alt="Thumbnail">
                                @endisset
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal"><i class="right fas fa-times mr-1"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="right fas fa-save mr-1"></i>
                            @if($showEditModal) <span>Save Changes</span> @else <span>Save</span> @endif
                            <div wire:loading wire:target="updateInvestment,createInvestment">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="suspendModal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content card-warning card-outline">
                <div class="modal-body text-center ">
                    <i class="fas fa-info-circle mt-2 text-warning" style="font-size: 100px"></i>
                    <div class="card-body text-center">
                        {{($status == true)? ' You are about to suspend this Investment Plan. Action will make it unavailable  for purchase untill reversed! ':' You are about to Activate this Investment Plan. Action will make the Plan for purchase untill suspended '}}
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="close-modal" type="button" class="btn btn-danger" data-dismiss="modal"><i class="right fas fa-times mr-1"></i>No, Cancel</button>
                    <button wire:click.prevent="suspendInvestment" class="btn btn-primary"><i class="right fas fa-trash mr-1"></i>Yes, {{($status == true)? ' Suspend ':' Activate '}}
                        <x-small-spinner condition="delay" target="suspendInvestment" />
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content card-danger card-outline">
                <div class="modal-body text-center ">
                    <i class="fas fa-info-circle mt-2 text-warning" style="font-size: 100px"></i>
                    <div class="card-body text-center">
                        You are about to delete this Investment Plan. Consider carefully, your action is irreversible
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="close-modal" type="button" class="btn btn-danger" data-dismiss="modal"><i class="right fas fa-times mr-1"></i>No, Cancel</button>
                    <button wire:click.prevent="deleteInvestment"  class="btn btn-primary"><i class="right fas fa-trash mr-1"></i>Yes, Delete
                        <x-small-spinner condition="delay" target="deleteInvestment" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>