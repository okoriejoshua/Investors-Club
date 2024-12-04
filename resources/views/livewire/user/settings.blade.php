<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item btn-small"><span class="goback"><i class="right fas fa-angle-left"></i></span></li>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    Settings
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
                    <div class="card mb-2 ">
                        <div class="card-header">
                            <h4 class="strong card-title">User Profile </h4>
                        </div>
                        <div id="security"   class="p-0 card-body">
                            <div class="transparent shadow-0  info-box mb-2">
                                <span class="info-box-icon">
                                    <img style="width:50px;height:50px" src="{{ auth()->user()->photo ? asset('storage/photos/'.auth()->user()->photo): asset('storage/photos/default.png')}}" class="img-circle elevation-2 border-1" alt="{{ auth()->user()->name}}">
                                </span>
                                <div class="info-box-content capital">
                                    <span class="small-size info-box-text">Profile</span>
                                    <span class="small-size info-box-text">Customize</span>
                                </div>
                                <span class="info-box-icon"><a href="{{route('user.profile')}}#info"><i class="fas fa-angle-right small-size"></i></a></span>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2 mt-2 ">
                        <div class="card-header">
                            <h4 class="strong card-title">Account Security </h4>
                        </div>
                        <div class="p-0 card-body border-bottom">
                            <div class="transparent shadow-0 p-0 info-box mb-2">
                                <span class="info-box-icon">
                                    <i class="fas fa-address-book icon-btn border-1 text-muted"></i>
                                </span>
                                <div class="info-box-content capital">
                                    <span class="small-size info-box-number">KYC</span>
                                    <small class="small-size info-box-text text-muted">Know Your Customer</small>
                                </div>
                                <span class="info-box-icon" wire:click="openKYCModal"> <x-small-spinner condition="delay" target="openKYCModal" /><i class="fas fa-angle-right small-size  ml-2 mt-3"></i></span>
                            </div>
                        </div>
                        <div class="p-0 card-body border-bottom">
                            <div class="transparent shadow-0 p-0 info-box mb-2">
                                <span class="info-box-icon">
                                    <i class="fas fa-rocket icon-btn border-1 text-muted"></i>
                                </span>
                                <div class="info-box-content capital">
                                    <span class="small-size info-box-number">Upgrades</span>
                                    <span class="small-size info-box-text text-muted">Upgrade your Account</span>
                                </div>
                                <span class="info-box-icon"><i class="fas fa-angle-right small-size"></i></span>
                            </div>
                        </div>

                        <div class="p-0 card-body border-bottom">
                            <div class="transparent shadow-0 p-0 info-box mb-2">
                                <span class="info-box-icon">
                                    <i class="fas fa-lock icon-btn border-1 text-muted"></i>
                                </span>
                                <div class="info-box-content capital">
                                    <span class="small-size info-box-number">Account Lock</span>
                                    <span class="small-size info-box-text text-muted">Lock your Account</span>
                                </div>
                                <span class="info-box-icon ">
                                    <small style="margin-top: -18px;" class="small-size p-2"> {{$isLock?'On':'Off'}}</small>
                                    <div class="custom-control custom-switch" wire:click="is_Lock">
                                        <input type="checkbox" class="custom-control-input" id="islock" wire:model="isLock">
                                        <label class="custom-control-label" for="islock"></label>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <div class="p-0 card-body border-bottom">
                            <div class="transparent shadow-0 p-0 info-box mb-2">
                                <span class="info-box-icon">
                                    <i class="fas fa-key icon-btn border-1 text-muted"></i>
                                </span>
                                <div class="info-box-content capital">
                                    <span class="small-size info-box-number">2-Factor</span>
                                    <span class="small-size info-box-text text-muted">Toggle 2-step verification</span>
                                </div>
                                <span class="info-box-icon ">
                                    <small style="margin-top: -18px;" class="small-size p-2"> {{$is2FA?'On':'Off'}}</small>
                                    <div class="custom-control custom-switch" wire:click="is_2FA">
                                        <input type="checkbox" class="custom-control-input" id="is2fa" wire:model="is2FA">
                                        <label class="custom-control-label" for="is2fa"></label>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <div class="p-0 card-body border-bottom">
                            <div class="transparent shadow-0 p-0 info-box mb-2">
                                <span class="info-box-icon">
                                    <i class="fas fa-wallet icon-btn border-1 text-muted"></i>
                                </span>
                                <div class="info-box-content capital">
                                    <span class="small-size info-box-number">Withdrawal PIN</span>
                                    <span class="small-size info-box-text text-muted">Manage Your Withdrawal PIN</span>
                                </div>
                                <span class="info-box-icon " data-toggle="dropdown" aria-expanded="false"><i class="fas fa-angle-right small-size"></i></span>
                                <div class="dropdown-menu prevent-default" role="menu">
                                    <div class="dropdown-item d-flex justify-content-between">
                                        <div class="custom-control custom-switch" wire:click="is_WP">
                                            <input type="checkbox" class="custom-control-input" id="togglewp" wire:model="isWP">
                                            <label class="custom-control-label" for="togglewp">
                                                {{$isWP?'On':'Off'}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-item  d-flex justify-content-between" wire:click="openWpinModal">
                                        <x-small-spinner condition="delay" target="openWpinModal" /><span> {{$showEditModal?'Change PIN ':'Setup PIN '}}</span>
                                        <i class="fas fa-angle-right p-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-0 card-footer">
                            <div class="transparent shadow-0 p-0 info-box mb-2">
                                <span class="info-box-icon">
                                    <i class="fas fa-trash icon-btn border-1 text-muted"></i>
                                </span>
                                <div class="info-box-content capital">
                                    <span class="small-size info-box-number">Delete Account</span>
                                    <span class="small-size info-box-text text-muted">Request Account Deletion</span>
                                </div>
                                <span class="info-box-icon"><i class="fas fa-angle-right small-size"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="strong card-title"> Miscellaneous </h4>
                        </div>
                        <div class="p-0 card-body border-bottom">
                            <div class="transparent shadow-0 p-0 info-box mb-2">
                                <span class="info-box-icon">
                                    <i class="fas fa-question icon-btn border-1 text-muted"></i>
                                </span>
                                <div class="info-box-content capital">
                                    <span class="small-size info-box-number">FAQ</span>
                                    <span class="small-size info-box-text text-muted">Frequently Asked Questions</span>
                                </div>
                                <span class="info-box-icon"><i class="fas fa-angle-right small-size"></i></span>
                            </div>
                        </div>

                        <div class="p-0 card-body border-bottom">
                            <div class="transparent shadow-0 p-0 info-box mb-2">
                                <span class="info-box-icon">
                                    <i class="fas fa-headset icon-btn border-1 text-muted"></i>
                                </span>
                                <div class="info-box-content capital">
                                    <span class="small-size info-box-number">Support</span>
                                    <span class="small-size info-box-text text-muted">helpline</span>
                                </div>
                                <span class="info-box-icon"><i class="fas fa-angle-right small-size"></i></span>
                            </div>
                        </div>

                        <div class="p-0 card-footer">
                            <div class="transparent shadow-0 p-0 info-box mb-2">
                                <span class="info-box-icon">
                                    <i class="fas fa-phone icon-btn border-1 text-muted"></i>
                                </span>
                                <div class="info-box-content capital">
                                    <span class="small-size info-box-number">Contact Us</span>
                                    <span class="small-size info-box-text text-muted">Get In touch With Us</span>
                                </div>
                                <span class="info-box-icon"><i class="fas fa-angle-right small-size"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="wpmodal" wire:ignore.self>
        <div class="bottom-fixed modal-dialog ">
            <div class="animate-bottom modal-content border-top">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{$showEditModal?'Change PIN ':' Setup New PIN  '}}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" autocomplete="off" wire:submit.prevent="{{$showEditModal?'updateWpin':'createWpin'}}">
                    <div class="card-body">
                        @if($showEditModal)
                        <div class="form-group row">
                            <label for="current_wpin" class="col-sm-12 col-form-label">Enter Current Withdrawal PIN </label>
                            <div class="col-sm-12">
                                <input type="password" id="current_wpin" maxlength="4" wire:model.defer="state.current_wpin" class="form-control @error('current_wpin') is-invalid @enderror " placeholder="Current Withdrawal PIN ">
                                @error('current_wpin')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                <small> Forgot PIN? <strong class="theme-color"><a href="#" style="color: inherit;">Request PIN Reset</a></strong></small>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label for="wpin" class="col-sm-12 col-form-label">Choose {{$showEditModal?'New ':''}} Withdrawal PIN</label>
                            <div class="col-sm-12">
                                <input type="number" maxlength="4" wire:model.defer="state.wpin" class="form-control  @error('wpin') is-invalid @enderror" id="wpin"
                                    placeholder="Four Digit PIN You Can Remeber ">
                                @error('wpin')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="wpin_confirmation" class="col-sm-12 col-form-label">Confirm Withdrawal PIN</label>
                            <div class="col-sm-12">
                                <input type="number" maxlength="4" wire:model.defer="state.wpin_confirmation" class="form-control  @error('wpin_confirmation') is-invalid @enderror" id="wpin_confirmation"
                                    placeholder="Confirm Withdrawal PIN ">
                                @error('wpin_confirmation')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="padding-10x20 radius-24 btn shadow-concave-xs theme-bg"><i class="right fas fa-save mr-1"></i>
                            {{$showEditModal?'Update Changes ':'Save Withdrawal Pin '}}
                            <x-small-spinner condition="delay" target="{{$showEditModal?'updateWpin':'createWpin'}}" />
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kycmodal" wire:ignore.self>
        <div class="bottom-fixed modal-dialog ">
            <div class="animate-bottom modal-content border-top">
                <div class="modal-header">
                    <h4 class="modal-title">KYC {{$step == 3?'Status':'Verification'}} </h4>
                    <span class="close btn" wire:click="close('kycmodal')">
                        <span>&times;</span>
                    </span>
                </div>
                <form class="form-horizontal" autocomplete="off" wire:submit.prevent="{{$step == 2 ? 'UploadKYC':'KYCDataSubmit'}}">
                    <div class="card-body scroll-y">
                        @if($step == 2)
                        <div id="photo_tab" class="mt-1">
                            <div class="form-group">
                                <div x-data="{ isUploading:false, progress:3 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false; progress=3 "
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                                    <label for="cardfront">Card Front </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input wire:model="cardfront" type="file" accept="image/*" class="custom-file-input  @error('cardfront') is-invalid @enderror" id="cardfront">
                                        </div>
                                        <div class="input-group-append">
                                            <label class="custom-file-label" for="cardfront">{{$cardfront?$cardfront->getClientOriginalName():'Upload Card Front'}}</label>
                                        </div>
                                    </div>
                                    <div x-show="isUploading" class="progress progress-xs ">
                                        <div :style="`width: ${progress}%`" class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                            aria-valuenow="3" aria-valuemin="0" aria-valuemax="100">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <img src="{{$cardfront?$cardfront->temporaryUrl():asset('storage/photos/front.png')}}" style="width:50%;border-radius:8px;" class="{{$cardfront?'':'opacity-0-4'}}p-2 border-1 m-1 text-center d-block" alt="card front">
                                <img src="{{$cardback?$cardback->temporaryUrl(): asset('storage/photos/back.png')}}" style="width:50%;border-radius:8px;" class="{{$cardfront?'':'opacity-0-4'}} p-2 border-1 m-1 text-center d-block" alt="card back">
                            </div>

                            <div class="form-group">
                                <div x-data="{ isUploading:false, progress:3 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false; progress=3 "
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <label for="cardback">Card Back</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input wire:model="cardback" type="file" accept="image/*" class="custom-file-input is-invalid" id="cardback">
                                        </div>
                                        <div class="input-group-append">
                                            <label class="custom-file-label" for="cardback">{{$cardback?$cardback->getClientOriginalName():'Upload Card Back'}}</label>
                                        </div>
                                    </div>
                                    <div x-show="isUploading" class="progress progress-xs ">
                                        <div :style="`width: ${progress}%`" class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                            aria-valuenow="3" aria-valuemin="0" aria-valuemax="100">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($step == 3)
                        <div id="status_tab" class="mt-1">
                            @if($kycdata->status == 'rejected')
                            <div class="p-2 card-body text-center">
                                <p><strong>Verification Unsuccessful</strong></p>
                                Unfortunately, we could not confirm your identity at this time.
                                If you think there is an error , please contact <a href="mailto:support@investor.com">support@investor.com</a> for further assistance.
                                <p><i class="fas fa-user-times mt-2 text-danger" style="font-size: 100px"></i></p>
                            </div>

                            @elseif($kycdata->status == 'approved')
                            <div class="p-2 card-body text-center">
                                <p><strong>Verification Successful</strong></p>
                                Your KYC verification was successful
                                <p><i class="fas fa-user-check mt-2 text-success" style="font-size: 100px"></i></p>
                            </div>


                            @else
                            <div class="p-2 card-body text-center">
                                <p><i class="fas fa-info-circle mt-2 text-orange" style="font-size: 100px"></i></p>
                                <p><strong>Verification Ongoing</strong></p>
                                Your Data is currently under manual review, and will contact you within 48 hours
                            </div>

                            @endif
                        </div>
                        @else
                        <div id="data_tab" class="mt-1">
                            <label for="card_type">Select Card</label>
                            <div class="input-group mb-3">
                                <select id="card_type" wire:model.defer="state.card_type" class="custom-select @error('card_type') is-invalid @enderror">
                                    <option selected>-- Select --</option>
                                    <option value="national_id">National ID</option>
                                    <option value="driver_license">Driver License</option>
                                    <option value="international_passport">International Passport</option>
                                </select>
                            </div>
                            @error('card_type')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror

                            <label for="country_issued">Select Card</label>
                            <div class="input-group mb-3">
                                <select id="country_issued" wire:model.defer="state.country_issued" class="custom-select @error('country_issued') is-invalid @enderror">
                                    <x-country-list></x-country-list>
                                </select>
                            </div>
                            @error('country_issued')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror

                            <label for="name_on_card">Name On Card</label>
                            <div class="input-group mb-3">
                                <input type="text" wire:model.defer="state.name_on_card" id="name_on_card" class="form-control @error('name_on_card') is-invalid @enderror" placeholder="Name on Your Card">
                            </div>
                            @error('name_on_card')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror

                            <label for="expiry">Expiry Date (Optional)</label>
                            <div class="input-group mb-3">
                                <input type="date" wire:model.defer="state.expiry" id="expiry" class="form-control @error('expiry') is-invalid @enderror">
                            </div>
                            @error('name_on_card')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror

                            <label for="serial_number">Card Serial Number (Optional)</label>
                            <div class="input-group mb-3">
                                <input type="number" wire:model.defer="state.serial_number" id="serial_number" class="form-control @error('serial_number') is-invalid @enderror">
                            </div>
                            @error('serial_number')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        @endif

                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        @if($step == 3)
                        <span wire:click="close('kycmodal')" class="padding-10x20 radius-24 btn btn-default shadow-concave-xs">Close</span>
                        @else
                        <button type="submit" class="padding-10x20 radius-24 btn shadow-concave-xs theme-bg">
                            Submit Data <x-small-spinner condition="delay" target="{{$step == 2 ? 'UploadKYC':'KYCDataSubmit'}}" />
                        </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>