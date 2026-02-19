@extends('layouts.public')

@section('title', 'Login - Tadika Alumni System')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i>Login</h4>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-info">{{ session('status') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">Please fix the errors below.</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="user_email" class="form-label fw-bold small text-secondary">Alamat Emel</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input id="user_email"
                                    class="form-control border-start-0 rounded-end-pill py-2 bg-light @error('user_email') is-invalid @enderror"
                                    type="email" name="user_email" value="{{ old('user_email') }}" required autofocus
                                    autocomplete="username" placeholder="nama@contoh.com" style="box-shadow: none;">
                            </div>
                            @error('user_email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold small text-secondary">Kata Laluan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input id="password"
                                    class="form-control border-start-0 rounded-end-pill py-2 bg-light @error('password') is-invalid @enderror"
                                    type="password" name="password" required autocomplete="current-password"
                                    placeholder="••••••••" style="box-shadow: none;">
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4 small">
                            <div class="form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input rounded-circle"
                                    name="remember">
                                <label class="form-check-label text-muted" for="remember_me">Ingat Saya</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary fw-bold">
                                    Lupa Kata Laluan?
                                </a>
                            @endif
                        </div>

                        <div class="d-grid mb-2">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold shadow-sm text-white">
                                <i class="fas fa-sign-in-alt me-2"></i> Log Masuk
                            </button>
                        </div>
                    </form>

                    <div class="text-center pt-3 border-top border-light">
                        <p class="text-muted small mb-2">Belum mempunyai akaun?</p>

                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="{{ route('alumni.register') }}"
                                class="btn btn-outline-warning text-dark fw-bold rounded-pill px-3 btn-sm shadow-sm transition-hover">
                                <i class="fas fa-user-graduate me-1"></i> Daftar Alumni
                            </a>
                            <a href="{{ route('tadika.register') }}"
                                class="btn btn-outline-info text-dark fw-bold rounded-pill px-3 btn-sm shadow-sm transition-hover">
                                <i class="fas fa-school me-1"></i> Daftar Tadika
                            </a>
                        </div>
                    </div>

                    <div class="text-center mt-4 text-muted small">
                        &copy; {{ date('Y') }} e-Tadika Portal
                    </div>
                </div>
            </div>
        </div>
        <style>
            /* Custom override for input focus to match theme */
            .form-control:focus {
                background-color: #fff;
                border-color: #0ea5e9;
            }

            .input-group-text {
                border-color: #dee2e6;
            }

            .input-group:focus-within .input-group-text {
                border-color: #0ea5e9;
                background-color: #fff;
            }

            .input-group:focus-within .form-control {
                border-color: #0ea5e9;
            }
        </style>
    </div>
@endsection