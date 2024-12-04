<div> <x-loading-indicator-targeted />
    <section class="content mb-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="p-2 card-body ">
                        <p class="d-flex justify-content-start">
                            <span>Total Balance </span>
                            <span>&nbsp;<i class="fas fa-eye-slash eye-hider-xs"></i></span>
                        </p>
                        <div class="d-flex justify-content-between">
                            <span class="asset-bal">$56,989.00</span>
                            <small style="display:inline-block" wire:click="goto('{{route('user.deposit')}}')" class="shadow-concave-xs btn-0 p-2 radius-24 border-1 px-3 strong">
                                <i class="fas fa-plus"></i> Add fund</small>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <span class="text-center" wire:click="goto('{{route('user.stake')}}')">
                                <i class="fas fa-hand-holding-usd shadow-concave-xs theme-bg-2 icon-btn  border-1 auto-margin-rl"></i>
                                <span>Earn</span>
                            </span>
                            <span class="text-center" wire:click="goto('{{route('user.withdraw')}}')">
                                <i class="fas fa-landmark shadow-concave-xs theme-bg-2 icon-btn border-1 auto-margin-rl"></i>
                                <span>Withdraw</span>
                            </span>
                            <span class="text-center" wire:click="goto('{{route('user.transfer')}}')">
                                <i class="fas fa-share-square shadow-concave-xs theme-bg-2 icon-btn border-1 auto-margin-rl"></i>
                                <span>Transfer</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-2"><strong>Hot Deal</strong></div>
                    <div class="p-2 card-body  border-radius">
                        <div id="hot-deal-carosal" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($plans as $plan )
                                <div class="carousel-item {{$plan->id==2 ? 'active':'' }}">
                                    <div wire:click="goto('{{route('user.purchase',['tab' =>$plan->slug])}}')">
                                        <div class="border radius-4">
                                            <div class="d-flex justify-content-between p-2">
                                                <div class="inner">
                                                    <h5>{{ strtoupper($plan->name) }}</h5>
                                                    <small>Invest in {{ ucwords($plan->slug) }}, and start earning passively with profitable R.O.I</small>
                                                </div>
                                                <div>
                                                    <img class="image-circle-80 shadow-concave-xs  {{ $plan->slug }}-bg-linear" src="@isset($plan->thumbnail) {{ asset('storage/investments/'.($plan->thumbnail))}} @else {{ asset('storage/photos/noimage.jpg')}} @endisset" alt="{{ $plan->name}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-2"><strong>Quick Access</strong></div>
                    <div class="p-2 card-body ">
                        <div class="d-flex justify-content-between">
                            <span class="text-center">
                                <i class="fas fa-piggy-bank shadow-concave-xs theme-bg-2 icon-btn border-1"></i>
                                <small>Stake</small>
                            </span>
                            <span class="text-center">
                                <i class="fas fa-user-friends shadow-concave-xs theme-bg-2 icon-btn border-1"></i>
                                <small>Referral</small>
                            </span>
                            <span class="text-center">
                                <i class="fas fa-trophy shadow-concave-xs theme-bg-2 icon-btn border-1"></i>
                                <small>Rewards</small>
                            </span>
                            <span class="text-center">
                                <i class="fas fa-crown shadow-concave-xs theme-bg-2 icon-btn border-1"></i>
                                <small>Premium</small>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="text-center">
                                <i class="fas fa-clock shadow-concave-xs theme-bg-2 icon-btn border-1"></i>
                                <small>Transactions</small>
                            </span>
                            <span class="text-center">
                                <i class="fas fa-user-check shadow-concave-xs theme-bg-2 icon-btn border-1"></i>
                                <small>KYC</small>
                            </span>
                            <span class="text-center">
                                <i class="fas fa-shield-alt shadow-concave-xs theme-bg-2 icon-btn border-1"></i>
                                <small>Security</small>
                            </span>

                            <span class="text-center">
                                <i class="fas fa-cog shadow-concave-xs theme-bg-2 icon-btn border-1"></i>
                                <small>Settings</small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-12 mt-4">
                    <div class="card mt-4">
                        <div class="modal-header ">
                            <h3 class="card-title">Simple Earn</h3>
                        </div>
                        <div class="row px-2">
                            @foreach ($stakes as $stake )
                            <div class="col-md-4 small-size" wire:click="goto('{{route('user.stake',['tab' =>$stake->slug])}}')">
                                <div class="info-box mb-2 shadow-concave-xs mt-3">
                                    <span class="info-box-icon">
                                        <img style="width:50px;height:50px" src="@isset($stake->photo) {{ asset('storage/investments/'.($stake->photo))}} @else {{ asset('storage/photos/noimage.jpg')}} @endisset" class="img-circle elevation-2 " alt="{{ $stake->name}}">
                                    </span>
                                    <div class="info-box-content capital">
                                        <span class="info-box-text">Earn Upto @monify($stake->profit)%</span>
                                        <span class="info-box-number">{{strtoupper($stake->name)}}</span>
                                    </div>
                                    <span class="info-box-icon"><i class="fas fa-angle-right small-size"></i></span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="card-footer text-center">
                            <span>&nbsp;</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>