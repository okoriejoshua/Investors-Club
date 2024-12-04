<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <span wire:click="@if($step > 0) backStep @else goBack @endif"><i class="right fas fa-angle-left"></i></span>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    Transfer Fund
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
                            <h3 class="modal-title mb-1 strong">Transfer</h3>
                        </div>
                        <form class="form-horizontal" autocomplete="off" wire:submit.prevent="makeTransfer">
                            @if($step == 1)
                            <div id="step-1" class="card-body p-3">
                                <label>Select Coin</label>
                                <div class="btn-group-toggle">
                                    @isset($paycoins)
                                    @foreach($paycoins as $paycoin)
                                    <label style="display: table;width: 98%;" class="d-flex justify-content-between  btn btn-default text-center m-1" @if($paycoin->status=='freezed' || $paycoin->amount<1) @else wire:click="Steps(2)" @endif>
                                            <small class="upper">
                                                <img style="width:30px;height:30px" src="{{ asset('storage/coins/'.$paycoin->coin.'.png')}}" class="border-1 img-circle mr-2" alt="{{ $paycoin->coin }}">
                                                {{str_replace('-', ' ',$paycoin->coin) }}
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
                            @elseif($step == 2)
                            <div id="step-2" class="card-body p-3">
                                @isset($selected)
                                <label>You are Sending Coin:</label>
                                <div wire:click="Steps(1)" class=" d-flex justify-content-between border radius-4 p-2 mb-1">
                                    <span class="strong upper">
                                        {{ (str_replace('-', ' ',$selected->coin)) }}
                                    </span>
                                    <i class="fas fa-angle-right mt-1"></i>
                                </div>

                                <label for="amount">Transfer Amount</label>
                                <div class="input-group mb-1">
                                    <input type="number" wire:model="state.amount" step="0.01" id="amount" class="border-1 form-control @error('amount') is-invalid @enderror" placeholder="Transfer amount">
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
                            @elseif($step==3)
                            <div class="card-body  step-2">
                                <h4>Confirm Details</h4>
                                <label for="coin"> Asset</label>
                                <div id="coin" class=" d-flex justify-content-between border radius-4 p-2 mb-1">
                                    <span class="strong upper">
                                        {{ (str_replace('-', ' ',$selected->coin)) }}
                                    </span>
                                </div>
                                <label> To</label>
                                <div class="upper text-muted  border radius-4 p-2 mb-1">
                                    <span>{{ $person->name  }}</span>
                                </div>
                                <label> Amount</label>
                                <div id="amt" class=" d-flex justify-content-between border radius-4 p-2 mb-1">
                                    <span class="strong">
                                        @monify($this->state['amount'])
                                    </span>
                                </div>
                            </div>
                            @else
                            <div id="step-0" class="card-body p-3">
                                <p class="text-warning "><i class="fas fa-info-circle"></i> Send funds to your friends through their ID or email</p>
                                <label for="person">Enter User ID or Email</label>
                                <div class="input-group mb-1">
                                    <input type="text" wire:model="state.person" id="person" class="border-1 form-control @error('amount') is-invalid @enderror" placeholder="ID or email">
                                    <div class="input-group-append">
                                        <span wire:click="findUser" class="input-group-text border-1"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                                <x-small-spinner condition="delay" target="findUser" />
                                @isset($person)
                                <label>Transfering to:</label>
                                <div class="upper text-muted  border radius-4 p-2 mb-1">
                                    <span>{{ $person->name  }}</span>
                                </div>
                                @else
                                <small> {{($this->isfound== 'nothing')?'User Not Found':''}}</small>
                                @endisset
                            </div>
                            @endif

                            <div class="card-footer d-flex justify-content-end">
                                @if($step==2)
                                <span wire:click="{{$usewpin == true?'showPINmodal':'Steps(3)'}}" class="padding-10x20   btn shadow-concave-xs theme-bg">
                                    Continue <x-small-spinner condition="delay" target="{{$usewpin == true?'showPINmodal':'Steps(3)'}}" />
                                </span>
                                @elseif($step==3)
                                <button type="submit" class="padding-10x20   btn shadow-concave-xs theme-bg">
                                    Submit <x-small-spinner condition="delay" target="makeTransfer" />
                                </button>
                                @elseif($step==0)
                                @isset($person)
                                <span wire:click="Steps(1)" class="padding-10x20   btn shadow-concave-xs theme-bg">
                                    Continue <x-small-spinner condition="delay" target="Steps(1)" />
                                </span>
                                @endisset
                                @else

                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
</div>