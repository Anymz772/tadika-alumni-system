<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'e-Tadika Portal') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

        <style>
            /* Apply rounded friendly font to body */
            body {
                font-family: 'Nunito', sans-serif;
                background-color: #f0f9ff; /* Alice Blue / Light Sky */
                /* Cute light blue polka dots */
                background-image: radial-gradient(#bae6fd 1.5px, transparent 1.5px);
                background-size: 24px 24px;
                color: #334155; /* Slate grey text for readability */
            }

            /* Headings use the chunky Fredoka font */
            h1, h2, h3, h4, h5, h6, .navbar-brand {
                font-family: 'Fredoka', sans-serif;
                letter-spacing: 0.5px;
                color: #0c4a6e; /* Dark Ocean Blue */
            }

            /* Custom Header Styling - Blue to Teal Gradient */
            header {
                background: linear-gradient(120deg, #3b82f6 0%, #22d3ee 100%);
                border-bottom: 4px solid #fff;
                border-radius: 0 0 25px 25px;
                box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
            }

            /* Card styling */
            .card {
                border: 2px solid #e0f2fe; /* Light blue border */
                border-radius: 15px;
                box-shadow: 0 4px 15px rgba(186, 230, 253, 0.3);
            }

            /* Buttons - Round and Bubbly */
            .btn {
                border-radius: 50px;
                font-weight: 700;
                padding: 0.5rem 1.5rem;
                transition: transform 0.2s;
            }
            .btn:hover {
                transform: scale(1.05); /* Pop effect */
            }

            .btn-primary {
                background-color: #0ea5e9; /* Sky Blue */
                border-color: #0ea5e9;
            }
            
            .btn-warning {
                background-color: #fbbf24; /* Sunny Yellow (Nice contrast with blue) */
                border-color: #fbbf24;
                color: #78350f;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen d-flex flex-column">
            
            @include('layouts.navigation')

            @if (isset($header))
                <header class="mb-4">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center sm:text-left">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white/20 p-2 rounded-circle">
                                <i class="fas fa-cloud text-white fs-3"></i>
                            </div>
                            <div class="text-white fs-4 fw-bold text-shadow-sm">
                                {{ $header }}
                            </div>
                        </div>
                    </div>
                </header>
            @endif

            @auth
                @if(auth()->user()->alumni)
                <div class="container mb-3">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('profile.edit', auth()->user()->alumni->id) }}" class="btn btn-warning shadow-sm">
                            <i class="fas fa-pencil-alt me-2"></i> Kemaskini Profil
                        </a>
                    </div>
                </div>
                @endif
            @endauth

            <main class="flex-grow-1 container pb-5">
                <div class="bg-white/90 backdrop-blur-sm p-4 rounded-[20px] shadow-sm border-2 border-sky-100">
                    @yield('content')
                </div>
            </main>

            <footer class="text-center py-4 text-muted small mt-auto">
                <div class="d-inline-block bg-white px-3 py-1 rounded-pill border border-sky-100 shadow-sm">
                    <i class="fas fa-rocket text-primary me-1"></i> 
                    <span class="fw-bold text-primary">Tadika Alumni System</span>
                </div>
            </footer>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>