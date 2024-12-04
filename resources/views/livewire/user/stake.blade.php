<div>
    <x-loading-indicator-targeted />
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <span wire:click="@if($step > 0) backStep @else goBack @endif"><i class="right fas fa-angle-left"></i></span>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    Stake & Earn
                </ol>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @isset($coindata)
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title mb-1">{{$tabTitle}}</h3>
                        </div>
                        <form class="form-horizontal" autocomplete="off" wire:submit.prevent="createStake">
                            <div class="card-body">
                                @if($step == 1)
                                <div id="price_tab" class="mt-1">
                                    <label for="amount">Enter Amount</label>
                                    <p><small class="text-warning">You can also select the amount you want to stake</small></p>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="number" wire:model="amount" id="amount" class="form-control" placeholder="staking amount">
                                    </div>
                                    <p><small class="text-muted">Available balance: {{ $availableBalance }} {{ custom_str_replace($coindata->coin_name, '-', ' ','upper') }}</small></p>
                                    @if($availableBalance==0)
                                    <p>Looks like your {{ custom_str_replace($coindata->coin_name, '-', ' ','upper') }} balance is low <br>
                                        <a href="{{route('user.deposit')}}" class="text-muted btn btn-default btn-xs">Deposit {{ custom_str_replace($coindata->coin_name, '-', ' ','upper') }} form External Wallet <i class="fas fa-arrow-right p-2"></i></a>
                                    </p>
                                    @endif

                                    <span class="btn btn-default btn-xs" wire:click="selectPercentage(25)">25%</span>
                                    <span class="btn btn-default btn-xs" wire:click="selectPercentage(50)">50%</span>
                                    <span class="btn btn-default btn-xs" wire:click="selectPercentage(75)">75%</span>
                                    <span class="btn btn-default btn-xs" wire:click="selectPercentage(100)">100%</span>
                                </div>
                                @elseif($step == 2)
                                <div id="confirm_tab" class="mt-1">
                                    <div class="mb-3  p-1">
                                        <p><strong>Staking Info</strong></p>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Amount</span>
                                            <span>{{ $amount }} {{ custom_str_replace($coindata->coin_name, '-', ' ','upper')}}</span>
                                        </div>
                                        <div class="d-flex justify-content-between border-bottom mb-4">
                                            <span>Duration</span>
                                            <span>{{ $radioDuration }} Days ( <small>ends {{$futureDate}}</small>)</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>APR</span>
                                            <span>{{ $apr }}%</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Earnings</span>
                                            <span>{{ $earnings }} {{custom_str_replace($coindata->coin_name, '-', ' ','upper')}}</span>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div id="duration_tab">
                                    <p>Stake {{ custom_str_replace($coindata->coin_name, '-', ' ','upper') }} and earn with the most profitable APR</p>
                                    <div class=" mt-1 d-flex justify-content-center btn-group-toggle">
                                        <label class="shadow-concave-xs btn btn-light text-center m-1" wire:click="selectAPR({{ $coindata->short_apr }})">
                                            <input type="radio" wire:model="radioDuration" name="radioDuration" autocomplete="off" value="{{ $coindata->short_duration }}">
                                            <i class="fas fa-hand-holding-usd text-danger" style="font-size: xxx-large;"></i><br>
                                            <small>{{ $coindata->short_duration }} Days </small><br>
                                            <small>@monify($coindata->short_apr)% Everyday</small>
                                        </label>
                                        <label class="shadow-concave-xs btn btn-light text-center m-1 " wire:click="selectAPR({{ $coindata->mid_apr }})">
                                            <input wire type="radio" wire:model="radioDuration" name="radioDuration" autocomplete="off" value="{{ $coindata->mid_duration }}">
                                            <i class="fas fa-hand-holding-usd text-warning" style="font-size: xxx-large;"></i><br>
                                            <small>{{ $coindata->mid_duration }} Days </small><br>
                                            <small>@monify($coindata->mid_apr)% Everyday</small>
                                        </label>
                                        <label class="shadow-concave-xs btn btn-light  text-center m-1" wire:click="selectAPR({{ $coindata->long_apr }})">
                                            <input type="radio" wire:model="radioDuration" name="radioDuration" autocomplete="off" value="{{ $coindata->long_duration }}">
                                            <i class="fas fa-hand-holding-usd text-success" style="font-size: xxx-large;"></i><br>
                                            <small>{{ $coindata->long_duration }} Days </small><br>
                                            <small>@monify($coindata->long_apr)% Everyday</small>
                                        </label>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="card-footer d-flex justify-content-center">
                                @if($step == 1)
                                <button type="button" class="padding-10x20 radius-24 btn theme-bg shadow-concave-xs" wire:click="nextStep" {{ $btnState }}>Proceed
                                    <x-small-spinner condition="delay" target="nextStep" />
                                </button>
                                @elseif ($step == 2)
                                <button type="submit" class="padding-10x20 radius-24 btn  theme-bg shadow-concave-xs">Confirm Stake </button>
                                @else
                                <button type="button" class="padding-10x20 radius-24 btn  theme-bg shadow-concave-xs" wire:click="nextStep()" {{ $btnState }}>Continue
                                    <x-small-spinner condition="delay" target="nextStep" />
                                </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="col-md-12">
                    <div class="card-body ">
                        <p class="d-flex justify-content-start">
                            <span>Total Earnings </span>
                            <span>&nbsp;<i class="fas fa-eye-slash eye-hider-xs"></i></span>
                        </p>
                        <div class="d-flex justify-content-between">
                            <h3 class="asset-bal">0 USD</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header ">
                            <h3 class="card-title">Active Earns</h3>
                        </div>
                        <div class="p-2 card-body">
                            <div class="content mt-2">
                                @isset($activestake)
                                @foreach($activestake as $onstake)
                                <div class="info-box mb-2 shadow-concave-xs ">
                                    <span style="width: 50px;" class="info-box-icon">
                                        <img style="width:30px;height:30px" src="@isset($onstake->photo) {{ asset('storage/investments/'.$onstake->photo)}} @else {{ asset('storage/photos/noimage.jpg')}} @endisset" class="img-circle" alt="{{ $onstake->plan_name}}">
                                    </span>
                                    <div class="info-box-content capital">
                                        <div class="d-flex justify-content-between">
                                            <small class="info-box-text">{{$onstake->amount}} {{custom_str_replace($onstake->plan_name, '-', ' ','upper')}}</small>
                                            <small class="info-box-text">{{$onstake->original_hour}}{{$onstake->return_type}} (ends {{ format_date($onstake->duration)}})</small>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small class="info-box-text">
                                                <strong>@monify($onstake->apr)% APR </strong>
                                                <span>Yield @monify($onstake->total_profit) <small class="small-size theme-color"> {{custom_str_replace($onstake->plan_name, '-', ' ','upper')}}</small></span>
                                            </small>
                                        </div>
                                        <div x-data="time_remain('{{ $onstake->duration }}')" x-init="init()" class="mb-2">
                                            <div class="d-flex justify-content-end">
                                                <template x-if="getTime() <= 0">
                                                    <small class="info-box-text btn btn-xs btn-default radius-12 px-2 theme-bg-2 shadow-concave-xs">Claim</small>
                                                </template>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <template x-if="getTime() > 0">
                                                    <small class="theme-color info-box-text btn btn-xs btn-default radius-12 px-2 shadow-concave-xs">
                                                        Claim: <span x-text="formatTime(getTime())"></span>
                                                    </small>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                    @if ($activestake->count() == $this->perPage)
                                    <div class="card-footer text-center" wire:click="loadMore">Load More <x-small-spinner condition="delay" target="loadMore" /></div>
                                    @endif
                                @else
                                <small class="text-center text-muted mb-4">You are yet to make a transaction</small>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="modal-header ">
                            <h3 class="card-title">Top Offer</h3>
                        </div>
                        <div class="p-2 card-body">
                            @foreach($stakes as $stake)
                            <a href="{{route('user.stake',['tab' =>$stake->coin_name])}}">
                                <label style="display: table;" class="d-flex justify-content-between  btn btn-default text-center m-1">
                                    <small class="capital">
                                        <img style="width:30px;height:30px" src="{{ asset('storage/coins/'.$stake->coin_name.'.png')}}" class="border-1 img-circle mr-2" alt="{{ $stake->coin_name }}">
                                        <span class="info-box-text"> @monify($stake->long_apr)% APR on</span>
                                        <span class="info-box-number">{{str_replace('-', ' ',$stake->coin_name) }}</span>
                                    </small>

                                    <small class="mt-2">
                                        <span class="info-box-icon"><i class="fas fa-angle-right"></i></span>
                                    </small>
                                </label>
                            </a>
                            @endforeach
                        </div>
                        <div class="card-footer text-center">
                            <span> View all</span>
                        </div>
                    </div>
                </div>
                @endisset
            </div>
        </div>
    </section>
</div>