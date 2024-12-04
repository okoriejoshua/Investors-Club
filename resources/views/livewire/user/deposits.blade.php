<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <span wire:click="@if($step > 0) backStep @else goBack @endif"><i class="right fas fa-angle-left"></i></span>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    Add funds
                </ol>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="modal-title mb-1 strong">Deposit</h3>
                        </div>
                        <form class="form-horizontal" autocomplete="off" wire:submit.prevent="{{$step==3?'uploadPOP':'saveDeposit'}}">
                            @if($step==1)
                            <div id="step-1">
                                <div class="btn-group-toggle">
                                    @isset($paycoins)
                                    @foreach($paycoins as $paycoin)
                                    <label style="display: table;width: 98%;" class="d-flex justify-content-between  btn btn-default text-center m-1" wire:click="selectCoin">
                                        <small>
                                            <img style="width:30px;height:30px" src="{{ asset('storage/coins/'.($paycoin->image))}}" class="img-circle mr-2" alt="{{ $paycoin->coin_name }}">
                                            Deposit {{custom_str_replace($paycoin->coin_name,'-',' ','upper') }}
                                        </small>
                                        <input type="radio" wire:model="state.asset" name="asset" autocomplete="off" value="{{ $paycoin->coin_name }}">
                                        <small> <i class="fas fa-angle-right mt-2"></i></small>
                                    </label>
                                    @endforeach
                                    @endisset
                                </div>
                            </div>
                            @elseif($step==2)
                            <div class="card-body  step-2">
                                <div wire:click="Steps(1)" class=" d-flex justify-content-between border radius-4 p-2 mb-1">
                                    <span class="strong">
                                        {{ custom_str_replace($scoin, '-', ' ','upper') }}
                                    </span>
                                    <i class="fas fa-angle-right mt-1"></i>
                                </div>

                                <label for="networkid">Network</label>
                                <div class="input-group mb-3">
                                    <select id="networkid" wire:model="state.networkid" class="border-1 custom-select @error('networkid') is-invalid @enderror">
                                        <option selected>-- Select --</option>
                                        @forelse($addresses as $address)
                                        <option value="{{$address->id}}">{{$address->network.' ('.$address->blockchain.')'}}</option>
                                        @empty
                                        <option disabled>Network is currently unavailable</option>
                                        @endforelse
                                    </select>
                                </div>
                                <x-small-spinner condition="delay" target="state.networkid" />
                                @isset($destination)
                                <label for="networkid">Deposit Address</label>
                                <p class="text-warning small-size"><i class="fas fa-info-circle"></i> Deposit only {{ strtoupper($destination->coin_name) }} on {{ $destination->blockchain }} Network</p>
                                <i class="fas fa-paste m-2" style="float:right;" onclick="copy('#toca');"></i>
                                <p wire:loading.class="text-muted" target="state.networkid" class="border-1 radius-8 p-2" id="toca">
                                    {{$destination->address}}
                                </p>
                                <label for="amount">Deposit Amount</label>
                                <div class="input-group mb-3">
                                    <input type="number" wire:model="state.amount" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Deposit amount">
                                </div>
                                @endisset
                            </div>
                            @elseif($step==3)
                            <div id="pop_tab" class="mt-1">
                                <label for="pop" class="p-3">Upload Proof Of Payment</label>
                                <div class="d-flex justify-content-center">
                                    <img src="{{$pop?$pop->temporaryUrl():asset('storage/pops/pop.png')}}" style="width:200px;border-radius:8px;" class="{{$pop?'':'opacity-0-4'}} p-2 border-1 m-1 text-center d-block" alt="pop">
                                </div>
                                <div class="form-group p-3">
                                    <div x-data="{ isUploading:false, progress:3 }"
                                        x-on:livewire-upload-start="isUploading = true"
                                        x-on:livewire-upload-finish="isUploading = false; progress=3 "
                                        x-on:livewire-upload-error="isUploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" wire:model="pop" accept="image/*" class="border-1 custom-file-input  @error('pop') is-invalid @enderror" id="pop">
                                            </div>
                                            <div class="input-group-append ">
                                                <label class="border-1 custom-file-label" for="pop">{{$pop?$pop->getClientOriginalName():'Upload POP'}}</label>
                                            </div>
                                        </div>
                                        <div x-show="isUploading" class="progress progress-xs ">
                                            <div :style="`width: ${progress}%`" class="progress-bar bg-success progress-bar-striped radius-4" role="progressbar"
                                                aria-valuenow="3" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="step-0">
                                <div class="p-0 card-body border-bottom border-top" wire:click="Steps(1)">
                                    <div class="transparent shadow-0 p-0 info-box mb-2">
                                        <span class="info-box-icon">
                                            <i class="fas fa-plus icon-btn border-1 text-muted"></i>
                                        </span>
                                        <div class="info-box-content capital">
                                            <span class="small-size info-box-number">Deposit Crypto</span>
                                            <span class="small-size info-box-text text-muted">Add crypto funds to your wallet</span>
                                        </div>
                                        <span class="info-box-icon"> <x-small-spinner condition="delay" target="Steps" /> <i class="fas fa-angle-right  small-size  ml-2 mt-3"></i></span>
                                    </div>
                                </div>
                                <div class="p-0 card-body border-bottom">
                                    <div class="transparent shadow-0 p-0 info-box mb-2">
                                        <span class="info-box-icon">
                                            <i class="fas fa-people-arrows icon-btn border-1 text-muted"></i>
                                        </span>
                                        <div class="info-box-content capital">
                                            <span class="small-size info-box-number">Request From Friends</span>
                                            <span class="small-size info-box-text text-muted">Request funds from your friends</span>
                                        </div>
                                        <span class="info-box-icon"><i class="fas fa-angle-right small-size"></i></span>
                                    </div>
                                </div>
                                <div class="p-0 card-body ">
                                    <div class="transparent shadow-0 p-0 info-box mb-2">
                                        <span class="info-box-icon">
                                            <i class="fas fa-hand-holding icon-btn border-1 text-muted"></i>
                                        </span>
                                        <div class="info-box-content capital">
                                            <span class="small-size info-box-number">Borrow Fund</span>
                                            <span class="small-size info-box-text text-muted">Borrow funds with a favourable interest rate and repay policy</span>
                                            <button class="btn-0 small-size text-muted border-1 radius-24">Coming Soon</button>
                                            <div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon theme-bg-radial">
                                                    Premium Only
                                                </div>
                                            </div>
                                        </div>
                                        <span class="info-box-icon"><i class="fas fa-angle-right small-size"></i></span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="card-footer d-flex justify-content-end">
                                @if($step==2 || $step==3)
                                <button type="submit" class="padding-10x20   btn shadow-concave-xs theme-bg">
                                    {{$step==3?'Upload POP':'Continue'}} <x-small-spinner condition="delay" target="{{$step==3?'uploadPOP':'saveDeposit'}}" />
                                </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="popalert" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content card-warning card-outline">
                <div class="modal-body text-center p-2">
                    <i class="fas fa-check-circle mt-2 text-success" style="font-size: 100px"></i>
                    <div class="card-body text-center p-2">
                        You transaction has been recorded. To ensure fairness, Please
                        upload Proof of Payment before the fund can be transfered to your account
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button wire:click="close('popalert')" type="button" class="padding-10x20 radius-24 btn shadow-concave-xs theme-bg">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="depositexist" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content card-warning card-outline">
                <div class="modal-body text-center p-2">
                    <i class="fas fa-check-circle mt-2 text-success " style="font-size:80px"></i>
                    <div class="card-body text-center p-2">
                        Hey! we saved your last incomplete transaction on this network. Do you want to continue?
                    </div>
                    @isset($transaction)
                    <div class="card-body text-left p-2">
                        <label for="networkid">{{ strtoupper($transaction->network) }} Deposit Address</label>
                        <i class="fas fa-paste m-2" style="float:right;" onclick="copy('#adr');"></i>
                        <p class="border-1 radius-8 p-2" id="adr" style="overflow-wrap: break-word;">
                            {{$transaction->destination}}
                        </p>
                        <label for="amount">Deposit Amount ({{ strtoupper($transaction->asset) }})</label>
                        <div class="border radius-4 p-2 mb-1">
                            <span class="strong">
                                @monify($transaction->amount)
                            </span>
                        </div>
                    </div>
                    @endisset
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button wire:click="Cancel(@isset($transaction){{$transaction->id}}@endisset)" class="radius-24 btn shadow-concave-xs btn-danger">
                        No Start New <x-small-spinner condition="delay" target="Cancel"></x-small-spinner>
                    </button>
                    <button wire:click="Steps(3)" class="radius-24 btn shadow-concave-xs theme-bg">Yes, Continue</button>
                </div>
            </div>
        </div>
    </div>
</div>