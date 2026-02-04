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
                            <small class="form-text text-muted">Email address will be used for login</small>
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

                <!-- Additional Information (Optional) -->
                <div class="form-section">
                    <h5><i class="fas fa-info-circle me-2"></i>Additional Information (Optional)</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ic_number" class="form-label">IC Number</label>
                            <input type="text" class="form-control @error('ic_number') is-invalid @enderror"
                                id="ic_number" name="ic_number" value="{{ old('ic_number') }}" maxlength="14">  
                            <small class="form-text text-muted">Format: YYMMDD-SS-XXXX</small>
                            @error('ic_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control @error('age') is-invalid @enderror"
                                id="age" name="age" value="{{ old('age') }}" min="1" max="100">
                            @error('age')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror"
                                id="state" name="state" value="{{ old('state') }}">
                            @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="tadika_name" class="form-label">Tadika Name</label>
                            <input type="text" class="form-control @error('tadika_name') is-invalid @enderror"
                                id="tadika_name" name="tadika_name" value="{{ old('tadika_name') }}" placeholder="Search or enter tadika name">
                            @error('tadika_name')
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const icNumberInput = document.getElementById('ic_number');
        const ageInput = document.getElementById('age');

        // Auto-format IC number input
        icNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, ''); // Remove non-digits

            if (value.length >= 6) {
                value = value.substring(0, 6) + '-' + value.substring(6);
            }
            if (value.length >= 9) {
                value = value.substring(0, 9) + '-' + value.substring(9);
            }
            if (value.length > 14) {
                value = value.substring(0, 14);
            }

            e.target.value = value;

            // Auto-calculate age from IC number
            if (value.length >= 6) {
                const birthDateStr = value.substring(0, 6);
                if (birthDateStr.length === 6) {
                    const age = calculateAgeFromIC(birthDateStr);
                    if (age !== null) {
                        ageInput.value = age;
                    }
                }
            }
        });

        // Function to calculate age from IC number birth date
        function calculateAgeFromIC(birthDateStr) {
            const year = parseInt(birthDateStr.substring(0, 2));
            const month = parseInt(birthDateStr.substring(2, 4)) - 1; // JS months are 0-indexed
            const day = parseInt(birthDateStr.substring(4, 6));

            // Determine full year (assuming 1900s for YY >= 50, 2000s for YY < 50)
            const fullYear = year >= 50 ? 1900 + year : 2000 + year;

            const birthDate = new Date(fullYear, month, day);
            const today = new Date();

            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            return age > 0 && age < 100 ? age : null;
        }
    });
</script>
@endpush
