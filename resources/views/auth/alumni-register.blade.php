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
                                <small class="form-text text-muted">Email address will be used for login</small>
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
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="full_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                    id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h6 class="mb-3 text-secondary">Additional Information (Optional)</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ic_number" class="form-label">IC Number</label>
                                <input type="text" class="form-control @error('ic_number') is-invalid @enderror"
                                    id="ic_number" name="ic_number" value="{{ old('ic_number') }}" placeholder="123456-12-3456">
                                <small class="form-text text-muted">Format: 123456-12-3456</small>
                                @error('ic_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
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

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control @error('age') is-invalid @enderror"
                                    id="age" name="age" value="{{ old('age') }}" min="1" max="100">
                                @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror"
                                    id="state" name="state" value="{{ old('state') }}">
                                @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="tadika_name" class="form-label">Tadika Name</label>
                                <input type="text" class="form-control @error('tadika_name') is-invalid @enderror"
                                    id="tadika_name" name="tadika_name" value="{{ old('tadika_name') }}" placeholder="Search or enter tadika name">
                                @error('tadika_name')
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
@endsection
