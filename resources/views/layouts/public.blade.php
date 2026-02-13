<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tadika Minda Inovasi')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="icon" href="{{ asset('images/tadika-logo.png') }}" type="image/png">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .tadika-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .tadika-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logo-img {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #2c3e50;
        }
        .logo-text h3 {
            margin: 0;
            font-weight: 700;
        }
        .logo-text p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        .main-nav {
            background-color: white;
            border-bottom: 1px solid #e0e0e0;
        }
        .nav-link {
            color: #2c3e50;
            font-weight: 500;
            padding: 15px 20px;
        }
        .nav-link:hover, .nav-link.active {
            color: #3498db;
            background-color: #f8f9fa;
        }
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 40px 0;
        }
        .tadika-footer {
            background-color: #2c3e50;
            color: white;
            padding: 30px 0;
            margin-top: 50px;
        }
        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            margin-right: 20px;
        }
        .footer-links a:hover {
            color: white;
        }
        .btn-tadika-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: 600;
        }
        .btn-tadika-primary:hover {
            background: linear-gradient(135deg, #2980b9 0%, #1f6396 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .card-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="tadika-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="tadika-logo">
                       <div class="logo-img">
    <img src="{{ asset('images/tadika-logo.png') }}" alt="Tadika Logo" style="width: 50px; height: 50px;">
</div>
                        <div class="logo-text">
                            <h3>TADIKA ALUMNI NETWORK</h3>
                            <p>Connecting Graduates Since 2000</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    @if(auth()->check())
                        <span class="me-3">Welcome, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="tadika-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="tadika-logo">
                       <div class="logo-img">
    <img src="{{ asset('images/tadika-logo.png') }}" alt="Tadika Logo" style="width: 50px; height: 50px;">
</div>
                        <div class="logo-text">
                            <h5>TADIKA ALUMNI NETWORK</h5>
                            <p>Building lasting connections</p>
                        </div>
                    </div>
                    <p class="mt-3" style="color: #bdc3c7;">
                        Official alumni network of Tadika Institution. 
                        Connecting graduates and fostering lifelong relationships.
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <div class="footer-links mt-3">
                        <a href="{{ url('/') }}"><i class="fas fa-home me-1"></i> Home</a><br>
                        <a href="{{ route('alumni.register') }}"><i class="fas fa-user-plus me-1"></i> Register</a><br>
                        <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> Login</a><br>
                        <a href="#"><i class="fas fa-question-circle me-1"></i> FAQ</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>Contact Info</h5>
                    <div class="mt-3">
                        <p style="color: #bdc3c7;">
                            <i class="fas fa-map-marker-alt me-2"></i> 
                            NO 14 &14 A, Tawas Idaman 3, Taman Tawas Idaman, 30010 Ipoh, Perak
                        </p>
                        <p style="color: #bdc3c7;">
                            <i class="fas fa-phone me-2"></i> 
                            05 2925956
                        </p>
                        <p style="color: #bdc3c7;">
                            <i class="fas fa-envelope me-2"></i> 
                            budi@madani.com.my
                        </p>
                    </div>
                </div>
            </div>
            <hr style="border-color: #4a6278;">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0" style="color: #bdc3c7;">
                        &copy; {{ date('Y') }} E-Tadika. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="text-light me-3"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>