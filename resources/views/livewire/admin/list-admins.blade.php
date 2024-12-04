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
                            <h3 class="card-title">Administrators</h3>
                            <div class="card-tools">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="input-group input-group-sm border border-light rounded" style="width: 150px;">
                                        <input wire:model="searchQuery" type="text" name="table_search" class="border-0 form-control float-left" placeholder="Search">
                                        <div wire:loading.delay wire:target="searchQuery" class="mt-1 pr-1">
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody wire:loading.class="text-muted" wire:target="searchQuery">
                                    @forelse ($admins as $admin)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$admin->name}}</td>
                                        <td>{{$admin->email}}</td>
                                        <td>

                                            <span class="btn btn-xs @if($admin->status=='active') btn-success    @else btn-danger   @endif ">
                                                @if($admin->status=='active') <i class="fas fa-check-circle"></i> Active @else <i class="fas fa-ban"></i> Suspended @endif
                                            </span>
                                        </td>
                                        <td>

                                            <span class="btn btn-xs @if($admin->role=='super admin') btn-outline-success    @elseif($admin->role=='admin') btn-outline-primary   @endif ">
                                                <i class="fas fa-check-circle"></i> @if($admin->role=='super admin') Super Admin @elseif($admin->role=='admin') Admin @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span wire:click.prevent="editModal({{$admin}})" class="badge bg-success p-2"><i class="fas fa-pen"></i> Manage</span>
                                            <span wire:click.prevent="confirmSuspendModal({{$admin->id}})" class="badge {{($admin->status =='active')? ' bg-danger ':'  bg-primary '}} p-2"><i class="fas fa-spinner"></i> {{($admin->status =='active')? 'Suspend':' Activate'}}</span>
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
                        <div class="card-footer d-flex justify-content-end">{{ $admins->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="addForm" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        @if($showEditModal) <span>Edit Admin</span> @else <span>Add New Admin</span> @endif
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" autocomplete="off" wire:submit.prevent="{{$showEditModal?'updateUser':'createUser'}}">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model.defer="state.name" class="form-control  @error('name') is-invalid @enderror" id="username" placeholder="username">
                                    @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="useremail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" wire:model.defer="state.email" class="form-control  @error('email') is-invalid @enderror" id="useremail" placeholder="Email">
                                    @error('email')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="userpassword" class="col-sm-2 col-form-label"> Password</label>
                                <div class="col-sm-10 input-group mb-3">
                                    <input type="text" wire:model.defer="state.password" class="form-control  @error('password') is-invalid @enderror" id="userpassword"
                                        placeholder="@if($showEditModal) Optional @else Enter Password @endif ">
                                    <div class="input-group-append">
                                        <div wire:click.prevent="generatePassword" wire:loading.attr="disabled" class="btn btn-dark">Generate</div>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input type="text" wire:model.defer="state.password_confirmation" class="form-control  @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                        placeholder="@if($showEditModal) Optional @else Confirm password @endif ">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- select -->
                            <div class="form-group row">
                                <label for="role" class="col-sm-2 col-form-label">Add Role</label>
                                <div class="col-sm-10">
                                    <select id="role" wire:model.defer="state.role" class="custom-select @error('role') is-invalid @enderror ">
                                        <option selected>--Select--</option>
                                        <option value="super admin">Super Admin - All privillege</option>
                                        <option value="admin">Admin - Limited privillege</option>
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal"><i class="right fas fa-times mr-1"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="right fas fa-save mr-1"></i>
                            @if($showEditModal) <span>Save Changes</span> @else <span>Save</span> @endif
                            <div wire:loading wire:target="updateUser, createUser">
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center ">
                    <i class="fas fa-info-circle mt-2 text-warning" style="font-size: 100px"></i>
                    <div class="card-body text-center">
                        {{($status == true)? ' You are about to suspend this User. Action will make the account inaccessible untill reversed! ':' You are about to Activate this User. Action will make the account accessible untill suspended '}}

                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="close-modal" type="button" class="btn btn-danger" data-dismiss="modal"><i class="right fas fa-times mr-1"></i>No, Cancel</button>
                    <button wire:click.prevent="suspendUser" class="btn btn-primary"><i class="right fas fa-trash mr-1"></i>Yes, {{($status == true)? ' Suspend ':' Activate '}}</button>
                </div>
            </div>
        </div>
    </div>
</div>