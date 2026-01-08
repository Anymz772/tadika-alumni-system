<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tadika Alumni CMS')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/tadika-logo.png') }}" type="image/png">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            width: 250px;
            position: fixed;
        }

        .sidebar .logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 2px 0;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid white;
        }

        .main-content {
            margin-left: 250px;
        }

        .top-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
        }

        .content-wrapper {
            padding: 20px;
            min-height: calc(100vh - 70px);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #4361ee;
            border-color: #4361ee;
        }

        .btn-primary:hover {
            background-color: #3a0ca3;
            border-color: #3a0ca3;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .sidebar.active {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.active {
                margin-left: 250px;
            }
        }
    </style>
</head>

<body>
    <!-- In the sidebar -->
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white">
        <h4 class="text-center py-3 border-bottom border-secondary">
            Tadika Admin
        </h4>

        <ul class="nav nav-pills flex-column mb-auto mt-3">

            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link text-white {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('alumni.index') }}"
                    class="nav-link text-white {{ Request::is('admin/alumni') ? 'active' : '' }}">
                    <i class="bi bi-people-fill me-2"></i> Manage Alumni
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('alumni.create') }}"
                    class="nav-link text-white {{ Request::is('admin/alumni/create') ? 'active' : '' }}">
                    <i class="bi bi-person-plus-fill me-2"></i> Add New Alumni
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ url('admin/surveys') }}"
                    class="nav-link text-white {{ Request::is('admin/surveys*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-clipboard-data me-2"></i> Survey Submission
                </a>
            </li>

        </ul>

        <hr>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn btn-outline-primary d-md-none" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4 class="mb-0 d-none d-md-inline">@yield('page-title', 'Dashboard')</h4>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">@yield('header-title', 'Dashboard')</h2>
                        <p class="text-muted mb-0">@yield('header-subtitle', 'Welcome to Tadika Alumni CMS')</p>
                    </div>
                    <div>@yield('header-buttons')</div>
                </div>
            </div>

            <!-- Main Content -->
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('mainContent').classList.toggle('active');
        });
    </script>

    @stack('scripts')
</body>

</html>