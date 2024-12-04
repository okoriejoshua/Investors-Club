<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item btn-small">
                        <span wire:click="@if($step > 0) backStep @else goBack @endif"><i class="right fas fa-angle-left"></i></span>
                    </li>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    Withdraw Fund 
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
                            <h3 class="modal-title mb-1 strong">Withdraw</h3>
                        </div>
                        <form class="form-horizontal" autocomplete="off" wire:submit.prevent="saveWithdraw">
                            @if($step==1)
                            <div class="card-body  step-1">
                                <div wire:click="Steps(0)" class=" d-flex justify-content-between border radius-4 p-2 mb-1">
                                    <span class="strong upper">
                                        {{ (str_replace('-', ' ',$scoin)) }}
                                    </span>
                                    <i class="fas fa-angle-right mt-1"></i>
                                </div>

                                <label for="networkid">Network</label>
                                <div class="input-group mb-3">
                                    <select id="networkid" wire:model="state.networkid" class="border-1 custom-select @error('networkid') is-invalid @enderror">
                                        <option selected>-- Select --</option>
                                        @forelse($addresses as $address)
                                        <option value="{{$address->coin_name.'-'.$address->network}}">{{$address->network.' ('.$address->blockchain.')'}}</option>
                                        @empty
                                        <option disabled>Network is currently unavailable</option>
                                        @endforelse
                                    </select>
                                </div>
                                <x-small-spinner condition="delay" target="state.networkid" />
                                @isset($selected)
                                <label for="destination">Withdrawal Address</label>
                                <p class="text-warning small-size"><i class="fas fa-info-circle"></i> Paste only {{ strtoupper($selected->coin) }} address on selected Network</p>
                                <div class="input-group  mb-3">
                                    <textarea wire:model="state.destination" id="destination" class="border-1 form-control @error('destination') is-invalid @enderror" placeholder="Withdtawal address"></textarea>
                                </div>
                                <label for="amount">Withdrawal Amount</label>
                                <div class="input-group mb-1">
                                    <input type="number" wire:model="state.amount" step="0.01" id="amount" class="border-1 form-control @error('amount') is-invalid @enderror" placeholder="Withdtawal amount">
                                    <div class="input-group-append">
                                        <span wire:click="maxBal" class="input-group-text border-1">All</span>
                                    </div>
                                </div>
                                <p class="small-size"> Balance: @monify($selected->amount)
                                    @error('amount')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                                </p>
                                @endisset
                            </div>
                            @elseif($step==2)
                            <div class="card-body  step-2">
                                <h4>Confirm Details</h4>
                                <label for="coin"> Asset</label>
                                <div id="coin" class=" d-flex justify-content-between border radius-4 p-2 mb-1">
                                    <span class="strong upper">
                                        {{ str_replace('-', ' ',$scoin) }}
                                    </span>
                                </div>
                                <label for="adr"> Withdrawal address</label>
                                <p class="border-1 radius-8 p-2" id="adr" style="overflow-wrap: break-word;">
                                    {{ $destination }}
                                </p>
                                <label for="amt"> Amount</label>
                                <div id="amt" class=" d-flex justify-content-between border radius-4 p-2 mb-1">
                                    <span class="strong">
                                        @monify($amountInput)
                                    </span>
                                </div>
                            </div>
                            @else
                            <div id="step-0">
                                <div class="btn-group-toggle">
                                    @isset($paycoins)
                                    @foreach($paycoins as $paycoin)
                                    <label style="display: table;width: 98%;" class="d-flex justify-content-between  btn btn-default text-center m-1" @if($paycoin->status=='freezed') @else wire:click="selectCoin" @endif>
                                        <small class="upper">
                                            <img style="width:30px;height:30px" src="{{ asset('storage/coins/'.$paycoin->coin.'.png')}}" class="border-1 img-circle mr-2" alt="{{ $paycoin->coin }}">
                                            {{str_replace('-', ' ',$scoin) }}
                                        </small>
                                        <input type="radio" wire:model="state.asset" name="asset" autocomplete="off" value="{{ $paycoin->coin }}">
                                        <small class="mt-2">
                                            @if($paycoin->status == 'freezed')<span class="btn btn-xs btn-default radius-12 px-2 text-danger ">suspended</span>@endif
                                            @monify($paycoin->amount)
                                        </small>
                                    </label>
                                    @endforeach
                                    @endisset
                                </div>
                            </div>
                            @endif

                            <div class="card-footer d-flex justify-content-end">
                                @if($step==1)
                                <span wire:click="{{$usewpin == true?'showPINmodal':'Steps(2)'}}" class="padding-10x20   btn shadow-concave-xs theme-bg">
                                    Submit <x-small-spinner condition="delay" target="{{$usewpin == true?'showPINmodal':'Steps(2)'}}" />
                                </span>
                                @elseif($step==2)
                                <button type="submit" class="padding-10x20   btn shadow-concave-xs theme-bg">
                                    Confirm Withdrawal <x-small-spinner condition="delay" target="saveWithdraw" />
                                </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="wdrs" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content card-warning card-outline">
                <div class="modal-body text-center p-2">
                    <i class="fas fa-check-circle mt-2 text-success" style="font-size: 100px"></i>
                    <div class="card-body text-center p-2">
                        <h4>Success!</h4>
                        Your order is being processed
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <span wire:click="close('wdrs')" class="padding-10x20 radius-24 btn shadow-concave-xs theme-bg">Close</span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="wpmodal" wire:ignore.self>
        <div class="bottom-fixed modal-dialog ">
            <div class="animate-bottom modal-content border-top">
                <div class="modal-header">
                    <h4 class="modal-title">Authentication Required</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="wpin" class="col-sm-12 col-form-label">Enter Withdrawal PIN </label>
                        <div class="col-sm-12">
                            <input type="password" id="wpin" maxlength="4" wire:model.delay="wpin" class="form-control " placeholder=" Withdrawal PIN ">
                            <small> Forgot PIN? <strong class="theme-color"><a href="#" style="color: inherit;">Request PIN Reset</a></strong></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <span wire:click="checkPin" class="padding-10x20 radius-24 btn shadow-concave-xs theme-bg">
                        <x-small-spinner condition="delay" target="checkPin" /> verify
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!--ends-->
</div>