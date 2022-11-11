<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RelaxArc Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item{{ request()->is('admin/dashboard') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Admin Menu -->
    @if (checkRoles(["ADMIN", "SUPERADMIN", 2], auth()->user()->roles))
    <li class="nav-item{{ request()->is('admin/users*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-user-tag"></i>
            <span>{{ __('Admin Menu') }}</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @endif

    <!-- Nav Item - Travel Package -->
    <li class="nav-item{{ request()->is('admin/travel-packages*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('travel-packages.index') }}">
            <i class="fas fa-hotel"></i>
            <span>{{ __('Travel Packages') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Travel Gallery -->
    <li class="nav-item{{ request()->is('admin/travel-galleries*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('travel-galleries.index') }}">
            <i class="fas fa-images"></i>
            <span>{{ __('Travel Galleries') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Transactions -->
    <li class="nav-item{{ request()->is('admin/transactions*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('transactions.index') }}">
            <i class="fas fa-cash-register"></i>
            <span>{{ __('Transactions') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>{{ __('Logout') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button type="button" class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
