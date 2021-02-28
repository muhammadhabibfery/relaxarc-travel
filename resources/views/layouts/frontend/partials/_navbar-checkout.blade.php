<!-- Navbar -->
<div class="container">
    <nav class="row navbar navbar-expand-md navbar-light bg-white">
        <!-- Navbar Brand Desktop -->
        <div class="navbar-nav ml-auto mr-auto mr-sm-auto mr-md-auto mr-lg-0 d-none d-lg-block">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('assets/frontend/images/logo11.png') }}" alt="logo">
            </a>
        </div>
        <ul class="navbar-nav mr-auto d-none d-lg-block">
            <li>
                <span class="text-muted">| &nbsp; Never go on trips with anyone you don't love</span>
            </li>
        </ul>

        <!-- Navbar Brand Mobile/Tablet -->
        <div
            class="navbar-nav ml-auto mr-auto mr-sm-auto mr-md-auto mr-lg-0 d-sm-block d-md-block d-lg-none d-xl-none text-center navbar-mobile">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('assets/frontend/images/logo11.png') }}" alt="logo">
                <span class="text-muted d-block">Never go on trips with anyone you don't love</span>
            </a>
        </div>
    </nav>
</div>
<!-- End Navbar -->
