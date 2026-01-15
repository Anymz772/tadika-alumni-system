@extends('layouts.public')

@section('title', 'Alumni Registration - Tadika Alumni System')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="survey-container">
            <div class="text-center mb-5">
                <h2 class="mb-3"><i class="fas fa-user-plus me-2"></i>Alumni Registration</h2>
                <p class="text-muted">Create your account to join the Tadika Alumni Network</p>
            </div>

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> Please fix the errors below.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form method="POST" action="{{ route('survey.store') }}">
                @csrf

                <!-- Account Information -->
                <div class="form-section">
                    <h5><i class="fas fa-user me-2"></i>Account Information</h5>

                    <div class="alert alert-info">
                        <small><i class="fas fa-info-circle me-2"></i>Only basic information is required. Additional details can be completed after registration via your profile page.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label required">Full Name</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                            @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label required">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label required">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label required">Confirm Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Terms and Submit -->
                <div class="form-section">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Quick Registration!</strong> Your account will be created immediately. You can log in right after registration and complete additional information in your profile.
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree that the information provided is accurate and I consent to
                            join the Tadika Alumni Network.
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-tadika-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i> Create Account
                        </button>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .survey-container {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .form-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .form-section h5 {
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .required::after {
        content: " *";
        color: #e74c3c;
    }

    .conditional-fields {
        transition: all 0.3s ease;
    }
</style>
@endpush