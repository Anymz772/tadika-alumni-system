<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Tadika Alumni')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <link rel="icon" href="{{ asset('images/tadika-logo.png') }}" type="image/png">

    <style>
        :root {
            --primary-blue: #0ea5e9;
            /* Sky Blue */
            --dark-blue: #0369a1;
            /* Ocean Blue */
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f0f9ff;
            color: #334155;
            margin: 0;
            overflow-x: hidden;
        }

        /* --- SIDEBAR STYLING --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #0ea5e9 0%, #2563eb 100%);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(14, 165, 233, 0.15);
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            font-family: 'Fredoka', sans-serif;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }

        .nav-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.7);
            padding: 25px 25px 10px;
            font-weight: 700;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 12px 25px;
            font-weight: 600;
            display: flex;
            align-items: center;
            border-left: 4px solid transparent;
            transition: all 0.2s;
            border-radius: 0 50px 50px 0;
            margin-right: 15px;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 30px;
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            border-left-color: #fbbf24;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-link i {
            width: 24px;
            margin-right: 10px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* --- MAIN CONTENT STYLING --- */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 15px 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.02);
            border-bottom: 1px solid #e0f2fe;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .content-wrapper {
            padding: 30px;
            flex-grow: 1;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            background-color: #fff;
            transition: transform 0.2s;
            border: 1px solid #f1f5f9;
        }

        h1, h2, h3, h4 {
            font-family: 'Fredoka', sans-serif;
            color: var(--dark-blue);
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.active {
                margin-left: 0;
                box-shadow: 10px 0 30px rgba(0, 0, 0, 0.1);
            }

            .main-content {
                margin-left: 0;
            }

            .overlay {
                display: none;
                position: fixed;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .overlay.active {
                display: block;
            }
        }
    </style>
</head>

<body>

    <div class="overlay" id="overlay"></div>

    <nav id="sidebar" class="sidebar d-flex flex-column flex-shrink-0">
        <div class="sidebar-header d-flex align-items-center justify-content-center">
            <i class="fas fa-shapes me-2 text-warning"></i>
            <span>{{ auth()->user()->isAdmin() ? 'Tadika Admin' : 'Tadika' }}</span>
        </div>

        <div class="overflow-auto" style="height: calc(100vh - 80px);">
            <div class="nav-label">Utama</div>

            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @elseif(auth()->user()->isTadika())
                <a href="{{ route('tadika.dashboard') }}"
                    class="nav-link {{ Request::is('tadika/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @elseif(auth()->user()->isAlumni())
                <a href="{{ route('profile.show') }}"
                    class="nav-link {{ Request::is('profile') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i> Dashboard
                </a>
            @endif

            @if(auth()->user()->isAdmin())
                <div class="nav-label">Pengurusan</div>

                @if (!Request::is('profile*'))
                    <a href="{{ route('alumni.index') }}"
                        class="nav-link {{ Request::is('alumni') || Request::is('alumni/*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> Senarai Alumni
                    </a>

                    <a href="{{ route('alumni.create') }}"
                        class="nav-link {{ Request::is('alumni/create') ? 'active' : '' }}">
                        <i class="bi bi-person-plus-fill"></i> Tambah Alumni
                    </a>

                    <a href="{{ route('tadika.index') }}"
                        class="nav-link {{ Request::is('tadika') || Request::is('tadika/*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i> Senarai Tadika
                    </a>

                    <a href="{{ route('tadika.create') }}"
                        class="nav-link {{ Request::is('tadika/create') ? 'active' : '' }}">
                        <i class="bi bi-building-add"></i> Tambah Tadika
                    </a>
                @endif
            @elseif(auth()->user()->isTadika())
                <div class="nav-label">Tadika</div>
                <a href="{{ route('tadika.profile.edit') }}"
                    class="nav-link {{ Request::is('tadika/profile/edit') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Profil Tadika
                </a>
                <a href="{{ route('tadika.alumni') }}"
                    class="nav-link {{ Request::is('tadika/alumni') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Alumni Tadika
                </a>
            @elseif(auth()->user()->isAlumni())
                <div class="nav-label">Alumni</div>
                <a href="{{ route('profile.edit') }}"
                    class="nav-link {{ Request::is('profile/edit') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square"></i> Kemaskini Profil
                </a>
            @endif

            <div class="nav-label">Akaun</div>

            <form action="{{ route('logout') }}" method="POST" class="mt-2 px-3">
                @csrf
                <button type="submit" class="btn btn-danger w-100 rounded-pill py-2 fw-bold shadow-sm">
                    <i class="bi bi-box-arrow-right me-2"></i> Log Keluar
                </button>
            </form>

            <div class="mt-auto p-4 text-center text-white-50 small">
                &copy; {{ date('Y') }} Tadika System
            </div>
        </div>
    </nav>

    <div class="main-content" id="mainContent">

        <nav class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-light text-primary d-md-none me-3 shadow-sm rounded-circle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="d-none d-md-block">
                    <h5 class="mb-0 fw-bold text-primary">@yield('page-title', 'Dashboard')</h5>
                    <small class="text-muted">Selamat datang, {{ Auth::user()->user_name }}</small>
                </div>
            </div>

            <div class="dropdown">
                <button
                    class="btn btn-white border rounded-pill px-3 py-1 shadow-sm dropdown-toggle d-flex align-items-center gap-2"
                    type="button" data-bs-toggle="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        {{ substr(Auth::user()->user_name, 0, 1) }}
                    </div>
                    <span class="d-none d-sm-inline small fw-bold text-secondary">{{ Auth::user()->user_name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-2">
                    <li>
                        <h6 class="dropdown-header">
                            @if(auth()->user()->isAdmin())
                                Akaun Admin
                            @elseif(auth()->user()->isTadika())
                                Akaun Tadika
                            @else
                                Akaun Alumni
                            @endif
                        </h6>
                    </li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2 text-muted"></i> Tetapan</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger fw-bold" type="submit">
                                <i class="fas fa-sign-out-alt me-2"></i> Log Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="content-wrapper">
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <h2 class="mb-1 fw-bold">@yield('header-title', '')</h2>
                    <p class="text-muted mb-0">@yield('header-subtitle', '')</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    @yield('header-buttons')
                </div>
            </div>

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleBtn = document.getElementById('sidebarToggle');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    </script>

    @stack('scripts')
</body>

</html>