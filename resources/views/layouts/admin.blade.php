<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Nindy</title>

    {{-- Google Fonts --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- AdminLTE & FontAwesome --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    {{-- Select2 & Cropper --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

    {{-- Custom Font --}}
    <style>
        body,
        .content-wrapper,
        .main-header,
        .main-sidebar {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        {{-- Preloader --}}
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="Logo"
                height="60" width="60">
        </div>

        {{-- Navbar --}}
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('cart.index') }}" class="nav-link">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                    </a>
                </li>
            </ul>

            <ul class="ml-auto navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            {{ Auth::user()->name }} <i class="ml-1 fas fa-caret-down"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="mr-2 fas fa-user"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="#" class="dropdown-item"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="mr-2 fas fa-sign-out-alt"></i> Logout
                                </a>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    @if (Route::has('register'))
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                    @endif
                @endauth
            </ul>
        </nav>

        {{-- Sidebar --}}
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @auth
                @if (Auth::user()->role === 'admin')
                    {{-- Sidebar Admin --}}
                    <a href="{{ route('admin.dashboard') }}" class="brand-link">
                        <i class="m-3 fas fa-tools"></i>
                        <span class="brand-text font-weight-light">Toko Admin</span>
                    </a>

                    <div class="sidebar">
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                                <li class="nav-item">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-tachometer-alt"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>
                                <li class="nav-header">MANAJEMEN DATA</li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.spareparts.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.spareparts.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-boxes"></i>
                                        <p>Spare Part</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.orders.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-receipt"></i>
                                        <p>Pesanan</p>
                                    </a>
                                </li>
                                <li class="nav-header">LAPORAN</li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.reports.sales') }}"
                                        class="nav-link {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-bar"></i>
                                        <p>Laporan Penjualan</p>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @else
                    {{-- Sidebar Pelanggan --}}
                    <a href="{{ route('home') }}" class="brand-link">
                        <i class="m-3 fas fa-store"></i>
                        <span class="brand-text font-weight-light">Toko Spare Part</span>
                    </a>

                    <div class="sidebar">
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                                <li class="nav-item">
                                    <a href="{{ route('home') }}"
                                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-store"></i>
                                        <p>Belanja</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cart.index') }}"
                                        class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-shopping-cart"></i>
                                        <p>Keranjang Saya</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('frontend.myOrders') }}"
                                        class="nav-link {{ request()->routeIs('frontend.myOrders') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-box-open"></i>
                                        <p>Pesanan Saya</p>
                                    </a>
                                </li>
                                {{--<li class="nav-header">AKUN SAYA</li>
                                <li class="nav-item">
                                    <a href="{{ route('profile.edit') }}"
                                        class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-user-edit"></i>
                                        <p>Edit Profile</p>
                                    </a>
                                </li>--}}
                            </ul>
                        </nav>
                    </div>
                @endif
            @else
                {{-- Sidebar untuk tamu --}}
                <a href="{{ route('home') }}" class="brand-link">
                    <i class="m-3 fas fa-store"></i>
                    <span class="brand-text font-weight-light">Toko Spare Part</span>
                </a>
                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column">
                            <li class="nav-item">
                                <a href="{{ route('home') }}"
                                    class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-store"></i>
                                    <p>Belanja</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('login') }}"
                                    class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-sign-in-alt"></i>
                                    <p>Login</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endauth
        </aside>

        {{-- Content --}}
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="mb-2 row">
                        <div class="col-sm-6">
                            <h1 class="m-0 fs-2 fw-bold">@yield('title')</h1>
                        </div>
                        <div class="text-right col-sm-6">
                            @yield('breadcrumb')
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        {{-- Footer --}}
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2025
                <a href="https://www.instagram.com/ndyayyy/">Nindy</a>.</strong> All rights reserved.
        </footer>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>
</html>
