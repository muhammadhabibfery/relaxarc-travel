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

    @include('layouts.frontend.partials._navbar')

    @yield('content')

    <!-- Delete Avatar Modal-->
    <div class="modal fade" id="deleteAvatarModal" tabindex="-1" role="dialog" aria-labelledby="deleteAvatarLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAvatarLabel">{{ __('Are you sure want to delete avatar?') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('delete-avatar') }}" method="POST" id="myfr">
                        @csrf
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.frontend.partials._footer')

    @include('layouts.frontend.partials._scripts')

    <!-- Addon Scripts -->
    @stack('addon_scripts')
</body>

</html>
