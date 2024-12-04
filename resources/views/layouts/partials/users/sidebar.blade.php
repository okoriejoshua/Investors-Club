 <aside class="main-sidebar sidebar-dark-primary elevation-4">
   <!-- Brand Logo -->
   <a href="index3.html" class="brand-link">
     <img src="{{ asset('backend/ui/img/AdminLTELogo.png')}}" alt=" Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
     <span class="brand-text font-weight-light">INVESTORS</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     <div class="user-panel mt-3 pb-3 d-flex">

       <div class="info">
         <div class="btn-group ">
           <div class="btn btn-default image">
             <img src="{{ asset('storage/photos/'.(auth()->user()->photo?auth()->user()->photo:'default.png'))}}" class="profile-photo-sidebar mt-2 img-circle elevation-2" alt="User Image">
             <span class="vip_level">
               <img style="width:18px; padding:0.4px" src="{{ asset('storage/photos/'.auth()->user()->vip_level.'.png')}}" alt="badge" title="{{auth()->user()->vip_level}} member">
             </span>
           </div>
           <a href="{{route('user.profile')}}" class=" btn btn-default">
             <small class="profile-name-sidebar"> {{auth()->user()->name}} </small>
             <br> <small class="text-muted">
               @if(auth()->user()->email_verified_at==NULL)
               <i class="fas fa-info-circle text-orange"></i> Unverified
               @else
               <i class="fas fa-info-circle text-success"></i> Verified
               @endif
             </small>
           </a>
           <a href="{{route('user.profile')}}" style="border-left:none!important" class="btn btn-default">
             <i class="fas fa-angle-right mt-3 "></i>
           </a>
         </div>
         <div class="d-flex justify-content-between mt-2 mb-0">
           <div>Mode </div>
           <div class="d-flex">
             <span class="small-size p-2" style="margin-top: -7px;" id="current-mode"> Night or Day</span>
             <div class="custom-control custom-switch" id="toggleDarkMode">
               <input type="checkbox" class="custom-control-input" id="mode">
               <label class="custom-control-label" for="mode"></label>
             </div>
           </div>
         </div>
       </div>
     </div>
     <!-- Sidebar Menu -->
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <li class="nav-item mb-0">
           <a href="{{route('user.dashboard')}}" class="nav-link {{ request()->is('user/dashboard') ? 'theme-bg-linear':'' }}">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Dashboard
             </p>
           </a>
         </li><!-- menu-is-opening menu-open-->

         <li class="nav-item {{ request()->is('user/withdraw') || request()->is('user/transfer') || request()->is('user/deposits') ? 'menu-is-opening menu-open' : '' }}">
           <a href="#" class="nav-link ">
             <i class="nav-icon fas fa-credit-card"></i>
             <p>
               Payment
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="{{route('user.deposit')}}" class="nav-link {{ request()->is('user/deposits')? 'theme-bg-linear' : '' }}">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Deposit</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="{{route('user.withdraw')}}" class="nav-link {{ request()->is('user/withdraw')? 'theme-bg-linear' : '' }}">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Withdraw</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="{{route('user.transfer')}}" class="nav-link {{ request()->is('user/transfer')? 'theme-bg-linear' : '' }}">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Make Transfer</p>
               </a>
             </li>
           </ul>
         </li>
         <li class="nav-item {{ request()->is('user/stake/*') || request()->is('user/stake') || request()->is('user/purchase-plan/*') ? 'menu-is-opening menu-open' : '' }}">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-hand-holding-usd"></i>
             <p>
               Simple Earn
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="{{route('user.purchase',['tab' =>'category'])}}" class="nav-link {{ request()->is('user/purchase-plan/*')? 'theme-bg-linear' : '' }}">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Invest</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="{{route('user.stake')}}" class="nav-link  {{ request()->is('user/stake') || request()->is('user/stake/*')? 'theme-bg-linear' : '' }}">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Stake</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>
                   View Active
                   <i class="right fas fa-angle-left"></i>
                 </p>
               </a>
               <ul class="nav nav-treeview" style="display: none;">
                 <li class="nav-item">
                   <a href="#" class="nav-link">
                     <i class="far fa-dot-circle nav-icon"></i>
                     <p>Active Investments</p>
                   </a>
                 </li>
                 <li class="nav-item">
                   <a href="#" class="nav-link">
                     <i class="far fa-dot-circle nav-icon"></i>
                     <p>Active Stakings</p>
                   </a>
                 </li>
               </ul>
             </li>
           </ul>
         </li>

         <li class="nav-item">
           <a href="{{route('user.history')}}" class="nav-link">
             <i class="nav-icon fas fa-clock"></i>
             <p>
               Transaction History
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="{{route('user.purchase',['tab' =>'category'])}}" class="nav-link">
             <i class="nav-icon fas fa-gift"></i>
             <p>
               Rewards
               <span class="right badge badge-danger">New</span>
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="{{route('user.settings')}}#security" class="nav-link">
             <i class="nav-icon fas fa-shield-alt"></i>
             <p>
               Security
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="{{route('user.purchase',['tab' =>'category'])}}" class="nav-link">
             <i class="nav-icon fas fa-bullhorn"></i>
             <p>
               Referal & Earn
               <span class="right badge badge-danger">New</span>
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="{{route('user.purchase',['tab' =>'category'])}}" class="nav-link">
             <i class="nav-icon fas fa-headset"></i>
             <p>
               Support
               <span class="right badge badge-danger">New</span>
             </p>
           </a>
         </li>
         <li class="nav-item">
           <a href="{{route('user.purchase',['tab' =>'category'])}}" class="nav-link">
             <i class="nav-icon fas fa-question-circle"></i>
             <p>
               Help Center
               <span class="right badge badge-danger">New</span>
             </p>
           </a>
         </li>

         <li class="nav-item mb-0">
           <a href="{{route('user.settings')}}" class="nav-link  {{ request()->is('user/settings') || request()->is('user/settings/*')? 'theme-bg-linear' : '' }}">
             <i class="nav-icon fas fa-cog"></i>
             <p>
               Settings
             </p>
           </a>
         </li>
         <li class="nav-item mb-0">
           <a data-toggle="modal" data-target="#signOutModal" href="#" class="nav-link">
             <i class="nav-icon fas fa-power-off"></i>
             <p>
               Sign Out
             </p>
           </a>
         </li>
         <li style="border-top:.5px solid #6c757d" class="nav-item mt-4">
           <a href="#" class="nav-link mt-2">
             <p>
               <small class="d-flex justify-content-between">
                 <span>
                   <i class="nav-icon fas fa-info-circle"></i>
                   About Investor
                 </span>
                 <i class="fas fa-angle-right right mt-1"></i>
               </small>
             </p>
           </a>
         </li>
       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>