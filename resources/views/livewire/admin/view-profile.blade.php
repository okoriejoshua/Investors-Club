<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item btn-small"><span class="goback"><i class="right fas fa-angle-left"></i></span></li>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    Profile
                </ol>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Left col -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Profile Details
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="card card-widget widget-user">
                                <div class="widget-user-header bg-info">
                                    <h5 class="widget-user-username capital">{{$ud->name}}</h5>
                                </div>
                                <!--asset('storage/photos/'.$ud->photo) -->
                                <div style="top:75px" class="widget-user-image mb-2" wire:click.prevent="openChangePhotoTab({{$ud->id}})">
                                    <img src="{{ $photo?$photo->temporaryUrl() : ($ud->photo ? asset('storage/photos/'.$ud->photo): asset('storage/photos/default.png'))}}" class="img-circle elevation-2" alt="User Image">
                                    <i class="fas fa-pen"></i>
                                    <div wire:loading.delay wire:target="openChangePhotoTab" class="mt-1 pr-1">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="sr-only">...</span>
                                        </div>
                                    </div>
                                </div>
                                <div x-data="{ isUploading:false, progress:3 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false; progress=3 "
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                                    <div x-show="isUploading" class="progress progress-xs ">
                                        <div :style="`width: ${progress}%`" class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                            aria-valuenow="3" aria-valuemin="0" aria-valuemax="100">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                    <p class="p-1">&nbsp;</p>
                                    <div wire:ignore.self id="uploadtab" class="p-2 active" style="display: none;">
                                        <form class="form-horizontal" autocomplete="off" wire:submit.prevent="savePhoto">
                                            <div class="form-group">
                                                <label for="changephoto">Change Photo</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input wire:model="photo" type="file" class="custom-file-input" id="changephoto">
                                                        <label class="custom-file-label" for="changephoto">{{$photo?$photo->getClientOriginalName():'Choose file'}}</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button type="submit" class="input-group-text btn btn-primary ">Upload</button>
                                                    </div>
                                                </div>
                                                @error('photo')
                                                <div class="invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer p-2">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Role
                                            <span class="badge  badge-pill">{{$ud->role}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Joined
                                            <span class="badge badge-pill">10-12-24</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Left col -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item active "><a class="nav-link" href="#info" data-toggle="tab">Edit Info</a></li>
                                <li class="nav-item"><a class="nav-link" href="#password-tab" data-toggle="tab">Change Password</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div wire:ignore.self class="tab-pane active" id="info">
                                    <form class="form-horizontal" autocomplete="off" wire:submit.prevent="updateProfileInfo">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" wire:model.defer="state.name" class="form-control  @error('name') is-invalid @enderror"
                                                        id="name" placeholder="Name">
                                                    @error('name')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="useremail" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" wire:model.defer="state.email" class="form-control  @error('email') is-invalid @enderror"
                                                        id="useremail" placeholder="Email">
                                                    @error('email')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="userphone" class="col-sm-2 col-form-label">Phone</label>
                                                <div class="col-sm-10">
                                                    <input type="number" wire:model.defer="state.phone"
                                                        class="form-control  @error('phone') is-invalid @enderror" id="userphone" placeholder="Phone Number">
                                                    @error('phone')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-end">
                                            <button type="submit" class="btn btn-primary">
                                                <span>Update Info</span>
                                                <div wire:loading wire:target="updateProfileInfo">
                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div wire:ignore.self class="tab-pane" id="password-tab">
                                    <form class="form-horizontal" autocomplete="off" wire:submit.prevent="updatePassword">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="current_password" class="col-sm-2 col-form-label">Old Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" id="current_password" wire:model.defer="state.current_password" class="form-control @error('current_password') is-invalid @enderror " placeholder="Current Password ">
                                                    @error('current_password')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="userpassword" class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="text" wire:model.defer="state.password" class="form-control  @error('password') is-invalid @enderror" id="userpassword"
                                                        placeholder="Password ">
                                                    @error('password')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                                                <div class="col-sm-10">
                                                    <input type="text" wire:model.defer="state.password_confirmation" class="form-control  @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                                        placeholder=" Confirm password ">
                                                    @error('password_confirmation')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-end"> <button type="submit" class="btn btn-primary"><i class="right fas fa-save mr-1"></i>
                                                <span>Save Password</span>
                                                <div wire:loading wire:target="updatePassword">
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>