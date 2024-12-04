<div>
    <x-loading-indicator-targeted />
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item btn-small"><span class="goback"><i class="right fas fa-angle-left"></i></span></li>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    Invest
                </ol>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                @if($tab=='category')
                                <li class="nav-item  btn-default">
                                    <a class="nav-link" wire:click.prevent="switchTab('category')">Investment Category</a>
                                </li>
                                @else
                                <div class="scroll-x d-flex justify-content-between">
                                    @foreach ($categories as $category)
                                    <a style="white-space: pre;" class="btn btn-default mr-2 {{$tab== $category->slug?'btn-active':''}} capital" wire:click.prevent="switchTab('{{ $category->slug }}')"> {{ $category->name }}</a>
                                    @endforeach
                                </div>
                                @endif
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane {{ $tab=='category'?'active':''}}" id="category">
                                    <div class="image-gallery">
                                        @foreach ($categories as $cat )
                                        <div class="imgcap position-relative border-1 radius-8" wire:click.prevent="switchTab('{{ $cat->slug }}')">
                                            <img src="@isset($cat->thumbnail) {{ asset('storage/investments/'.($cat->thumbnail))}} @else {{ asset('storage/photos/noimage.jpg')}} @endisset" alt="{{ $cat->name}}">
                                            <div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon theme-bg-radial">
                                                    {{$cat->name}}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @foreach ($categories as $individual )
                                <div class="tab-pane {{ $tab==$individual->slug?'active':''}} " id="{{$individual->name}}">
                                    <div class="airdrop-card">
                                        @foreach ($plans as $plan )
                                        <div class="small-box {{ $plan->category }}-bg-linear">
                                            <div class="d-flex justify-content-between p-2">
                                                <div class="inner">
                                                    <h5>{{ $plan->name }}</h5>
                                                    <small>Buy {{ ucwords($plan->category) }}, and earn passively with a starting amount of $@monify($plan->min_price) </small>
                                                </div>
                                                <div class="{{ $plan->category }}-shadow {{ $plan->category }}-bg-linear p-2">
                                                    <img class="image-circle-80" src="{{ asset('storage/investments/'.$plan->photo)}}" alt="Airdrop Image">
                                                </div>
                                            </div>
                                            <div class="small-box-footer p-2 d-flex justify-content-between "><small class="p-2 btn btn-outline btn-xs text-white">Earn @monify($plan->profit)% R.O.I </small>
                                                <small wire:click.prevent="openBuyModal({{$plan->id}})" style="border-radius: 20px !important; padding-left:9px" class="btn btn-default btn-xs">Buy Now <i class="fas fa-arrow-right p-2"></i></small>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="buyModal" wire:ignore.self>
        <div class="bottom-fixed modal-dialog">
            @isset($selectedPlan)
            <div class="animate-bottom modal-content">
                <form class="form-horizontal" autocomplete="off" wire:submit.prevent="createPurchase">

                    <div class="d-flex justify-content-between" style="margin-top: -30px;">
                        <p>&nbsp;</p>
                        <div class="{{ $selectedPlan->category }}-shadow {{ $selectedPlan->category }}-bg-linear ">
                            <img style="width:100px;border-radius: 50%;" src="{{ asset('storage/investments/'.$selectedPlan->photo)}}" alt="{{$selectedPlan->name}} ">
                        </div>
                        <p>&nbsp;</p>
                    </div>

                    <div class="modal-body text-center ">
                        <h4>{{$selectedPlan->name}}</h4>
                        <p> With the Minimum of <strong class="text-success">$@monify($selectedPlan->min_price)</strong>, You can earn upto $@monify($selectedPlan->profit)%
                            ROI within the next <strong class="text-success">{{ $selectedPlan->numdays }}</strong> {{ $selectedPlan->return_type }}.

                        </p>
                        <div class="form-group row ">
                            <label for="amount" class="text-left pl-2">Enter Amount</label>
                            <div class="col-sm-12 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" wire:model.defer="state.amount" class="form-control  @error('amount') is-invalid @enderror" id="amount" placeholder=" amount">
                                @error('amount')
                                <div class="p-2 badge-light text-danger invalid-feedback ">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong class="text-success">MIN: $@monify($selectedPlan->min_price)</strong>
                            <strong class="text-success">MAX: $@monify($selectedPlan->max_price)</strong>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-end">
                        <button id="close-modal" type="button" class="btn btn-default shadow-concave-xs" data-dismiss="modal">Close</button>
                        <button type="submit" class="theme-bg-radial btn text-white border shadow-concave-xs">Continue <x-small-spinner condition="delay" target="createPurchase" /></button>
                    </div>
                </form>
            </div>
            @endisset
        </div>
    </div>
    <div class="modal fade" id="previewModal" wire:ignore.self>
        <div class="bottom-fixed modal-dialog">
            @isset($tabdata)
            <div class="animate-bottom  modal-content">
                <div class="d-flex justify-content-center" style="margin-top: -30px;">
                    <img class="theme-bg-2 border-1 radius-4" style="width:150px;" src="@isset($tabdata->thumbnail) {{ asset('storage/investments/'.($tabdata->thumbnail))}} @else {{ asset('storage/photos/noimage.jpg')}} @endisset" alt="">
                </div>
                <div class="modal-body text-center ">
                    <h4>{{$tabdata->name}}</h4>
                    <p>{{$tabdata->description}}</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="close-modal" type="button" class="padding-10x20 radius-24 btn theme-bg-radial btn text-white border shadow-concave-xs" data-dismiss="modal">Explore</button>
                </div>
            </div>
            @endisset
        </div>
    </div>
</div>