<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item btn-small">
                        <span wire:click="goBack"><i class="right fas fa-angle-left"></i></span>
                    </li>
                </ol>
                <ol class="breadcrumb float-sm-right">
                    Transaction History
                </ol>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card card-default">
                        <div class="content-header">
                            <div class="d-flex justify-content-between">
                                <ol class="breadcrumb float-sm-left">
                                    <li class="card-title strong">
                                        Transactions
                                    </li>
                                </ol>
                                <ol class="breadcrumb float-sm-right">
                                    <li wire:click="open('categorymodal')" class="card-title strong">
                                        <i class="fas fa-filter"></i>
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <div class="btn-group d-flex justify-content-between ">
                            <div wire:click="setTab('list')" class="btn btn-default col-md-6  text-center {{$tab=='list'?'theme-bg':''}} capital">{{$category}}</div>
                            <div wire:click="setTab('pending')" class="btn btn-default col-md-6  text-center {{$tab=='pending'?'theme-bg':''}}">Pending</div>
                        </div>
                        @if($tab == 'list')
                        <div class="p-2 card-body all">
                            @forelse($transactions as $transact)
                            <div wire:click.prevent="getDetails({{$transact->id}})">
                                <div class="info-box mb-2 shadow-xs ">
                                    <span style="width: 30px; font-size: 1.4rem" class="info-box-icon">
                                        @if($transact->type == 'deposit')
                                        <i style="width: 50px;" class="fas fa-arrow-circle-down"></i>
                                        @elseif($transact->type == 'reward')
                                        <i style="width: 50px;" class="fas fa-gift"></i>
                                        @elseif($transact->type == 'withdraw')
                                        <i style="width: 50px;" class="fas fa-arrow-circle-up"></i>
                                        @elseif($transact->type == 'transfer' && $transact->from_id == auth()->user()->user_id)
                                        <i style="width: 50px;" class="fas fa-arrow-circle-up"></i>
                                        @elseif($transact->type == 'transfer' && $transact->to_id == auth()->user()->user_id)
                                        <i style="width: 50px;" class="fas fa-arrow-circle-down"></i>
                                        @else
                                        <i style="width: 50px;" class="fas fa-clock"></i>
                                        @endif
                                    </span>
                                    <div class="info-box-content capital">
                                        <span class="info-box-text">
                                            @if($transact->type == 'transfer' && $transact->from_id == auth()->user()->user_id)
                                            Transfer Out
                                            @elseif($transact->type == 'transfer' && $transact->to_id == auth()->user()->user_id)
                                            Received
                                            @else
                                            {{$transact->type}}
                                            @endif
                                        </span>
                                        <span class="info-box-text"><small class="small-size">{{format_date($transact->created_at)}}</small></span>
                                    </div>
                                    <div style="text-align: end;" class="info-box-content capital">
                                        <span class="info-box-text upper">
                                            @if($transact->type == 'transfer' && $transact->to_id == auth()->user()->user_id || $transact->type == 'deposit' || $transact->type == 'reward') + @else - @endif
                                            $@monify($transact->amount) {{str_replace('-',' ',$transact->asset)}}</span>
                                        <span class="info-box-text"><small class="small-size">{{$transact->status}}</small></span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="empty">
                                <div class="text-center p-2">
                                    <i class="fas fa-clock mt-2 auto-margin-rl opacity-0-4" style="font-size: 60px;"></i>
                                    <div class="card-body text-center p-2">
                                        <span>No Transaction Found</span>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        @if ($transactions->count() == $this->perPage)<div class="card-footer text-center" wire:click="loadMore">Load More <x-small-spinner condition="delay" target="loadMore" />
                        </div> @endif
                        @else
                        <div class="p-2  card-body pending">
                            @forelse($pendings as $pending)
                            <div wire:click.prevent="getDetails({{$pending->id}})">
                                <div class="info-box mb-2 shadow-xs ">
                                    <span style="width: 30px; font-size: 1.4rem" class="info-box-icon">
                                        @if($pending->type == 'deposit')
                                        <i style="width: 50px;" class="fas fa-arrow-circle-down"></i>
                                        @elseif($pending->type == 'reward')
                                        <i style="width: 50px;" class="fas fa-gift"></i>
                                        @elseif($pending->type == 'withdraw')
                                        <i style="width: 50px;" class="fas fa-arrow-circle-up"></i>
                                        @elseif($pending->type == 'transfer' && $pending->from_id == auth()->user()->user_id)
                                        <i style="width: 50px;" class="fas fa-arrow-circle-up"></i>
                                        @elseif($pending->type == 'transfer' && $pending->to_id == auth()->user()->user_id)
                                        <i style="width: 50px;" class="fas fa-arrow-circle-down"></i>
                                        @else
                                        <i style="width: 50px;" class="fas fa-clock"></i>
                                        @endif
                                    </span>
                                    <div class="info-box-content capital">
                                        <span class="info-box-text">{{$pending->type}}</span>
                                        <span class="info-box-text"><small class="small-size">{{format_date($pending->created_at)}}</small></span>
                                    </div>
                                    <div style="text-align: end;" class="info-box-content capital">
                                        <span class="info-box-text upper">
                                            @if($pending->type == 'deposit') + @else - @endif
                                            $@monify($pending->amount) {{str_replace('-',' ',$pending->asset)}}</span>
                                        <span class="info-box-text"><small class="small-size">{{$pending->status}}</small></span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="empty">
                                <div class="text-center p-2">
                                    <i class="fas fa-clock mt-2 auto-margin-rl opacity-0-4" style="font-size: 60px;"></i>
                                    <div class="card-body text-center p-2 capital">
                                        <span>No {{$category}} Found</span>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        @if ($pendings->count() == $this->perPage)<div class="card-footer text-center" wire:click="loadMore">Load More <x-small-spinner condition="delay" target="loadMore" />
                        </div>@endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="categorymodal" wire:ignore.self>
        <div class="bottom-fixed modal-dialog ">
            <div class="animate-bottom modal-content border-top">
                <div class="modal-header">
                    <label class="float-sm-left">Quick Select </label>
                    <label class="float-sm-right strong" wire:click="close('categorymodal')" style="font-size:20px;margin-top: -10px;">&times;</label>
                </div>
                <div class="card-body scroll-y">
                    <div class="d-flex justify-content-between">
                        <label class="col-sm-6 col-form-label">Quick Select </label>
                        <x-small-spinner condition="delay" target="changeCategory" />
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 mb-4">
                            <div class="btn-group-toggle">
                                <label wire:click="changeCategory('all')" class="border-1 btn {{$category=='all'?'theme-bg':'btn-default'}} shadow-xs text-center m-1 radius-24">
                                    <input type="radio" wire:model="category" name="category" autocomplete="off" value="all">
                                    <small>All Categories</small>
                                </label>
                                <label wire:click="changeCategory('transfer')" class="border-1 btn  {{$category=='transfer'?'theme-bg':'btn-default'}} shadow-xs text-center m-1 radius-24">
                                    <input type="radio" wire:model="category" name="category" autocomplete="off" value="transfer">
                                    <small>Transfer</small>
                                </label>
                                <label wire:click="changeCategory('deposit')" class="border-1 btn  {{$category=='deposit'?'theme-bg':'btn-default'}} shadow-xs text-center m-1 radius-24">
                                    <input type="radio" wire:model="category" name="category" autocomplete="off" value="deposit">
                                    <small>Deposits</small>
                                </label>
                                <label wire:click="changeCategory('withdraw')" class="border-1 btn {{$category=='withdraw'?'theme-bg':'btn-default'}} shadow-xs text-center m-1 radius-24">
                                    <input type="radio" wire:model="category" name="category" autocomplete="off" value="withdraw">
                                    <small>Withdrawals</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="history-details" wire:ignore.self>
        <div class="bottom-fixed modal-dialog ">
            <div class="animate-bottom modal-content">
                @isset($details)
                <div class="d-flex justify-content-center" style="margin-top: -30px;">
                    <img class="theme-bg-2" style="width:40px;height:40px;border-radius:50%;" src="{{ asset('storage/coins/'.$details->asset.'.png')}}" alt="">
                </div>
                <div class="title text-center">
                    <label class="text-center">Transaction Details </label>
                </div>
                <div class="card-body scroll-y border-top p-2">
                    <div class="border-1 radius-8 text-center mb-2">
                        <h2 class="strong mb-0 mt-2 upper">
                            @if($details->type == 'transfer' && $details->to_id == auth()->user()->user_id || $details->type == 'deposit' || $details->type == 'reward') + @else - @endif
                            @monify($details->amount) {{str_replace('-',' ',$details->asset)}}</h2>
                        <label class="text-center text-green">
                            <small class="py-2  @if($details->status == 'pending') text-warning @elseif($details->status == 'failed') text-danger @elseif($details->status == 'successful') text-success @else @endif ">
                                {{ucwords($details->status)}}
                            </small>
                        </label>

                    </div>
                    <div class="d-flex justify-content-between p-2 mb-1">
                        <span class="">Issues</span>
                        <span class="">Support <i class="fas fa-headset"></i> </span>
                    </div>
                    <div class="border-1 radius-8 ">
                        <div class="d-flex justify-content-between p-2 border-bottom">
                            <span class="">Type</span>
                            <span class="capital">{{$details->type}} </span>
                        </div>
                        <div class="d-flex justify-content-between p-2 border-bottom">
                            <span class="">Amount</span>
                            <span class="upper">@monify($details->amount) {{str_replace('-',' ',$details->asset)}} </span>
                        </div>
                        <div class="d-flex justify-content-between p-2 border-bottom">
                            <span class="">Transaction ID</span>
                            <span class="">#{{$details->transaction_id}} </span>
                        </div>
                        @if($details->type=='withdraw' || $details->type=='deposit')
                        <div class="d-flex justify-content-between p-2 border-bottom">
                            <span class="">Network</span>
                            <span class="capital">{{$details->network}} </span>
                        </div>
                        <div class="p-2 border-bottom">
                            <span class="">Address</span>
                            <p class="break-word border-1 radius-8 p-2 ">
                                {{$details->destination}}
                            </p>
                        </div>
                        @else
                        <div class="d-flex justify-content-between p-2 border-bottom">
                            <span class="">Pay Method</span>
                            <span class="capital">{{$details->paymethod}} </span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between p-2 ">
                            <span class="">Date</span>
                            <span class="">{{format_date($details->created_at)}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 d-flex justify-content-center  border-top">
                    <label wire:click="close('history-details')" class="theme-bg mt-2 border-1 btn padding-10x20 shadow-xs text-center m-1 radius-24">
                        Close
                    </label>
                </div>
                @endisset
            </div>
        </div>
    </div>
</div>