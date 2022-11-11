<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ trans('status.has_complete_profile.title') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.hell.sh/basic.css/1.1/basic.css"
        integrity="sha384-t9jp7agVAouhXYQbh8e3NWEQd74qiwIpXk0BUnxCz3DYK8do1LvzXPtPGRh8BM04" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Toastr CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <style>
        p {
            margin: 0
        }
    </style>

</head>

<body>
    <section class="text-center">
        <p style="font-size:150px">401</p>
        <h6>
            <strong>Whoops</strong>
            <span class="d-block mt-2">{{ trans('status.has_complete_profile.paragraph') }}</span>
        </h6>
        @if (checkRoles(["ADMIN",1], auth()->user()->roles))
        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-outline-light mt-3">{{ __('Back to dashoard')
            }}</a>
        @else
        <a href="{{ route('front-profile') }}" class="btn btn-secondary btn-outline-light mt-3">{{ __('Back to profile')
            }}</a>
        @endif
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>

    <!-- Toastr JS Library-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        @if(session('verifiedStatus'))
        toastr.closeButton = true,
        toastr.options.positionClass = "toast-top-center";
        toastr.options.progressBar = true;
        toastr.options.showDuration = 500;
        toastr.success("{!! session('verifiedStatus') !!}", 'Sukses');
        @endif
    </script>

</body>

</html>
