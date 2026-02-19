@extends('layouts.public')

@section('title', 'Tadika Registration - Tadika Alumni System')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="survey-container">
            <div class="text-center mb-5">
                <h2 class="mb-3"><i class="fas fa-school me-2"></i>Tadika Registration</h2>
                <p class="text-muted">Register your Tadika to access the system</p>
            </div>

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> Please fix the errors below.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form method="POST" action="{{ route('tadika.register') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-section">
                    <h5><i class="fas fa-id-card me-2"></i>Required Information</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tadika_name" class="form-label required">Tadika Name</label>
                            <input type="text" class="form-control @error('tadika_name') is-invalid @enderror"
                                id="tadika_name" name="tadika_name" value="{{ old('tadika_name') }}" required>
                            @error('tadika_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tadika_reg_no" class="form-label required">Registration Number</label>
                            <input type="text" class="form-control @error('tadika_reg_no') is-invalid @enderror"
                                id="tadika_reg_no" name="tadika_reg_no" value="{{ old('tadika_reg_no') }}" required>
                            @error('tadika_reg_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tadika_district" class="form-label required">District</label>
                            <input type="text" class="form-control @error('tadika_district') is-invalid @enderror"
                                id="tadika_district" name="tadika_district" value="{{ old('tadika_district') }}" required>
                            @error('tadika_district')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tadika_state" class="form-label required">State</label>
                            <input type="text" class="form-control @error('tadika_state') is-invalid @enderror"
                                id="tadika_state" name="tadika_state" value="{{ old('tadika_state') }}" required>
                            @error('tadika_state')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tadika_email" class="form-label required">Tadika Email</label>
                            <input type="email" class="form-control @error('tadika_email') is-invalid @enderror"
                                id="tadika_email" name="tadika_email" value="{{ old('tadika_email') }}" required>
                            <small class="form-text text-muted">This email will be used for login</small>
                            @error('tadika_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label required">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
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

                <div class="form-section">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Your Tadika account will be created immediately. You can add more details after login.
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label" for="terms">
                            I confirm that the information provided is accurate.
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-tadika-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i> Register Tadika
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
</style>
@endpush