<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BERR | @yield('title', 'DASHBOARD')</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('/public/images/icons/icon-2.webp') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        .sidebar {
            background: #111827;
            box-shadow: 2px 0 12px #0003;
            height: 100vh;
            left: 0;
            position: fixed;
            top: 0;
            transition: all .3s;
            width: 260px;
            z-index: 1000
        }

        .sidebar-header {
            border-bottom: 1px solid #374151;
            color: #f9fafb;
            font-size: 1.25rem;
            font-weight: 600;
            padding: 1.5rem 1rem;
            text-align: center
        }

        .sidebar-menu .nav-link {
            align-items: center;
            border-radius: .5rem;
            color: #d1d5db;
            display: flex;
            gap: .5rem;
            padding: .75rem 1.25rem;
            transition: all .2s
        }

        .sidebar-menu {
            padding: 1rem
        }

        .nav-link {
            border-radius: 8px;
            color: #b3b3b3;
            margin: .25rem 0;
            padding: .75rem 1.5rem;
            transition: all .3s
        }

        .nav-link:hover {
            background: #2d2d2d;
            color: #fff
        }

        .nav-link.active {
            background-color: #121213;
            border-left: 4px solid #3b82f6;
            border-radius: 0;
            color: #fff;
            font-weight: 500
        }

        .sidebar.collapsed {
            overflow: hidden;
            width: 0
        }

        .main-content.collapsed {
            margin-left: 0
        }

        .main-content {
            margin-left: 260px;
            transition: all .3s
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -260px
            }

            .sidebar.active {
                left: 0
            }

            .main-content {
                margin-left: 0
            }

            .overlay {
                background: #00000080;
                bottom: 0;
                display: none;
                left: 0;
                position: fixed;
                right: 0;
                top: 0;
                z-index: 999
            }

            .sidebar.active+.overlay {
                display: block
            }
        }

        .navbar {
            background: #fff;
            box-shadow: 0 2px 10px #0000001a
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: #4f46e5;
            font-size: 1.5rem
        }

        .sidebar {
            transition: width .3s
        }

        .main-content {
            transition: margin-left .3s
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="mb-0">BERR</h3>
            <small>Dashboard</small>
        </div>
        <div class="sidebar-menu">
            <nav class="nav flex-column">
                <a class="nav-link {{request()->routeIs('dashboard') ? 'active' : ''}}" href="{{route('dashboard')}}">
                    <i class="bi bi-house me-2"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                    href="{{ route('admin.categories.view') }}">
                    <i class="bi bi-tags me-2"></i> Categories
                </a>

                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                    href="{{ route('admin.products.view') }}">
                    <i class="bi bi-bag me-2"></i> Products
                </a>

            </nav>
        </div>
    </div>

    <!-- Overlay for mobile -->
    <div class="overlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i id="sidebarToggleIcon" class="bi bi-list"></i>
                </button>

                <h5 class="mb-0"
                    style="font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
                    @yield('title', 'DASHBOARD')</h5>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a class="btn btn-link" href="#" role="button" id="userMenu" data-bs-toggle="dropdown">
                            <i class="bi bi-grid fs-4"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-house-door me-2"></i> Home
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-bag me-2"></i> Shop
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-cart me-2"></i> Cart
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid p-4">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('public/js/sweet-alert-function.js') }}"></script>

    <script>
        $(document).ready(function () {
            toggleSidebar(true);
        });

        function toggleSidebar(firstLoad = false) {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const toggleIcon = document.getElementById('sidebarToggleIcon');
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                if (!firstLoad) sidebar.classList.toggle('active');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');

                const isCollapsed = sidebar.classList.contains('collapsed');
                toggleIcon.classList.remove('bi-list', 'bi-x');
                toggleIcon.classList.add(isCollapsed ? 'bi-list' : 'bi-x');
            }
        }
    </script>


    @stack('scripts')
</body>

</html>