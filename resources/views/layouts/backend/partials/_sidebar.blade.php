<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RelaxArc Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    {{-- <hr class="sidebar-divider"> --}}

    <!-- Nav Item - Admin Menu -->
    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-user-tag"></i>
            <span>Menu Admin</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Travel Package -->
    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-hotel"></i>
            <span>Paket Travel</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Travel Gallery -->
    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-images"></i>
            <span>Galeri Travel</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Transactions -->
    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-cash-register"></i>
            <span>Transaksi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button type="button" class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
