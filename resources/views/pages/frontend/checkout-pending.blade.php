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

    @include('layouts.frontend.partials._styles')

    <title>Checkout Pending</title>
</head>

<body>

    @include('layouts.frontend.partials._navbar-checkout')

    <!-- Content -->
    <main>
        <div class="section-success d-flex align-items-center pb-5 mt-2">
            <div class="col text-center">
                <img src="{{ asset('assets/frontend/images/checkout-pending.png') }}" alt="success checkout"
                    class="img-fluid">
                <h1>One step closer ...</h1>
                <p>You haven't completed the payment process <br> Please continue the payment process</p>
            </div>
        </div>
    </main>
    <!-- End Content -->

    @include('layouts.frontend.partials._scripts')
</body>

</html>
