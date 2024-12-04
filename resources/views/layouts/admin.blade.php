<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'phpridles') }}</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/ui/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/ui/css/custom.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/toastr/toastr.min.css')}}">
  <livewire:styles />
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="{{ asset('backend/ui/img/AdminLTELogo.png')}}" alt="logo" height="60" width="60">
    </div>
    <!-- Navbar -->
    @include('layouts.partials.admins.navbar')
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    @include('layouts.partials.admins.sidebar')
    <!-- / Main Sidebar Container -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      {{$slot}}
    </div>

    <!-- Main Footer -->
    @include('layouts.partials.admins.footer')
  </div>

  <!-- REQUIRED SCRIPTS -->
  <script src="{{ asset('backend/plugins/jquery/jquery.min.js')}}"></script>
  <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <script src="{{ asset('backend/plugins/toastr/toastr.min.js')}}"></script>
  <script src="{{ asset('backend/ui/js/adminlte.js')}}"></script>
  <script src="{{ asset('backend/ui/js/events.function.js')}}"></script>
  <livewire:scripts />
  <!--script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></!--script-->
  <script src="{{ asset('backend/ui/js/alpinejs.v2.js')}}"></script>
</body>

</html>