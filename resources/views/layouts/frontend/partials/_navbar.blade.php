<!-- Navbar -->
<div class="container">
    <nav class="row navbar navbar-expand-md navbar-light bg-white">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset('assets/frontend/images/logo11.png') }}" alt="logo relaxarc">
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navb">
            <ul class="navbar-nav ml-auto mr-3">
                <li class="nav-item mx-md-2">
                    <a href="{{ route('home') }}" class="nav-link active">Home</a>
                </li>
                <li class="nav-item mx-md-2">
                    <a href="#" class="nav-link">Paket Travel</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbard" data-toggle="dropdown">Service</a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Link</a>
                        <a href="#" class="dropdown-item">Link 2</a>
                        <a href="#" class="dropdown-item">Link 3</a>
                    </div>
                </li>
                {{-- <li class="nav-item mx-md-2">
                    <a href="#" class="nav-link">Testimonial</a>
                </li> --}}
                <!-- Nav Item - User Information -->
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{ __('Account') }}
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                            <img class="img-profile rounded-circle" src="{{ auth()->user()->getAvatar() }}">
                        </a>
                        @if (isSuperAdmin())
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            {{ __('Dashboard') }}
                        </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('front-profile') }}">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            {{ __('Profile') }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('front-change-password') }}">
                            <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                            {{ __('Change password') }}
                        </a>
                    </div>
                </li>
                @endauth
            </ul>

            @guest
            <!-- Mobile Button -->
            <form class="form-inline d-sm-block d-md-none">
                <button class="btn btn-login my-2 my-sm-0" type="button"
                    onclick="event.preventDefault(); location.href='{{ route('login') }}'">Masuk</button>
            </form>

            <!-- Tablet Button -->
            <form class="form-inline my-lg-0 d-none d-md-block d-lg-none">
                <button class="btn btn-login btn-navbar-right-tablet my-2 my-sm-0 px-4" type="button"
                    onclick="event.preventDefault(); location.href='{{ route('login') }}'">Masuk</button>
            </form>

            <!-- Desktop Button -->
            <form class="form-inline my-2 my-lg-0 d-none d-lg-block">
                <button class="btn btn-login btn-navbar-right-desktop my-2 my-sm-0 px-4" type="button"
                    onclick="event.preventDefault(); location.href='{{ route('login') }}'">Masuk</button>
            </form>
            @endguest

            @auth
            <!-- Mobile Button -->
            <form action="{{ route('logout') }}" method="POST" class="form-inline d-sm-block d-md-none" id="myfr">
                @csrf
                <button class="btn btn-login my-2 my-sm-0" id="btnfr" type="submit">{{ __('Keluar') }}</button>
            </form>

            <!-- Tablet Button -->
            <form action="{{ route('logout') }}" method="POST" class="form-inline my-lg-0 d-none d-md-block d-lg-none"
                id="myfr">
                @csrf
                <button class="btn btn-login btn-navbar-right-tablet my-2 my-sm-0 px-4" id="btnfr"
                    type="submit">{{ __('Keluar') }}</button>
            </form>

            <!-- Desktop Button -->
            <form action="{{ route('logout') }}" method="POST" class="form-inline my-2 my-lg-0 d-none d-lg-block"
                id="myfr" id="btnfr">
                @csrf
                <button class="btn btn-login btn-navbar-right-desktop my-2 my-sm-0 px-4"
                    type="submit">{{ __('Keluar') }}</button>
            </form>
            @endauth
        </div>
    </nav>
</div>
<!-- End Navbar -->
