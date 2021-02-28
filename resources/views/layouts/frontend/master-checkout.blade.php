<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Addon Links -->
    @stack('addon_links')

    @include('layouts.frontend.partials._styles')

    <title>@yield('title')</title>
</head>

<body>

    @include('layouts.frontend.partials._navbar-checkout')

    @yield('content')

    @include('layouts.frontend.partials._footer')

    @include('layouts.frontend.partials._scripts')

    <!-- Addon Scripts -->
    @stack('addon_scripts')
</body>

</html>
