@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Alumni Registration
                    </h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('alumni.register') }}">
                        @csrf

                        <h5 class="mb-3 text-primary">Account Information</h5>
                        <div class="alert alert-info">
                            <small><i class="fas fa-info-circle me-2"></i>Only basic information is required. Additional details can be completed after registration via your profile page.</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name *</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address *</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password *</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password-confirm" class="form-label">Confirm Password *</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <h5 class="mb-3 text-primary">Personal Information</h5>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="full_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                    id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Quick Registration!</strong> Your account will be created immediately. You can log in right after registration and complete additional information in your profile.
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>

                            <div class="text-center mt-3">
                                <p class="mb-0">
                                    Already have an account?
                                    <a href="{{ route('login') }}" class="text-decoration-none">
                                        <i class="fas fa-sign-in-alt me-1"></i>Login here
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // No conditional field logic needed - all fields are always visible for registration
</script>
@endpush
@endsection