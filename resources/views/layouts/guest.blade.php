<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'phpridles') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/ui/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/ui/css/custom.css')}}">
</head>

<body class="dark-mode login-page" style="min-height: 496.781px;">
    <div class="login-box">
            <x-application-logo />
        {{ $slot }}
    </div>
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('backend/ui/js/adminlte.js')}}"></script>
</body>

</html>