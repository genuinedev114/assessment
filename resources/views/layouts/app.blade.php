<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('page_title', config('app.name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/luxe-ui.css') }}" rel="stylesheet">
    @stack('styles')
    <script src="https://kit.fontawesome.com/ca00268a38.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="ui-page-loader" role="status" aria-live="polite" aria-label="Loading page">
        <div class="ui-page-loader-spinner"></div>
        <span class="ui-page-loader-text">Loading...</span>
    </div>

    <div class="app-layout">

        <aside class="sidebar">
            <div class="sidebar-brand">
                <i class="fas fa-utensils"></i>
                <span>Yum! Brands</span>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard.index') }}" class="sidebar-nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('dashboard.stores') }}" class="sidebar-nav-item {{ request()->routeIs('dashboard.stores') ? 'active' : '' }}">
                    <i class="fas fa-store"></i>
                    <span>Stores</span>
                </a>
                <a href="{{ route('dashboard.journals') }}" class="sidebar-nav-item {{ request()->routeIs('dashboard.journals') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Daily Journals</span>
                </a>
                <a href="{{ route('dashboard.export') }}" class="sidebar-nav-item {{ request()->routeIs('dashboard.export') ? 'active' : '' }}">
                    <i class="fas fa-download"></i>
                    <span>Export Data</span>
                </a>
            </nav>
        </aside>


        <div class="main-content">

            <nav class="topnav">
                <div class="brand-filter">
                    @yield('brand-pills')
                </div>
                <div class="user-info">
                    @auth
                        <span>{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @endauth
                </div>
            </nav>


            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="d-none" data-flash-type="success" data-flash-title="Success" data-flash-message="{{ session('success') }}"></div>
    @endif

    @if (session('error'))
        <div class="d-none" data-flash-type="error" data-flash-title="Error" data-flash-message="{{ session('error') }}"></div>
    @endif

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/luxe-ui.js') }}"></script>
    @stack('scripts')
</body>
</html>
