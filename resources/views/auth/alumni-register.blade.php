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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="full_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="ic_number" class="form-label">IC Number</label>
                                <input type="text" class="form-control @error('ic_number') is-invalid @enderror" 
                                       id="ic_number" name="ic_number" value="{{ old('ic_number') }}">
                                @error('ic_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="year_graduated" class="form-label">Year Graduated *</label>
                                <input type="number" class="form-control @error('year_graduated') is-invalid @enderror" 
                                       id="year_graduated" name="year_graduated" 
                                       min="2000" max="{{ date('Y') }}" value="{{ old('year_graduated') }}" required>
                                @error('year_graduated')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contact_number" class="form-label">Contact Number *</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" 
                                       id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required>
                                @error('contact_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="current_workplace" class="form-label">Current Workplace</label>
                                <input type="text" class="form-control" 
                                       id="current_workplace" name="current_workplace" value="{{ old('current_workplace') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="job_position" class="form-label">Job Position</label>
                                <input type="text" class="form-control" 
                                       id="job_position" name="job_position" value="{{ old('job_position') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        </div>

                        <h5 class="mb-3 text-primary">Parents Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="father_name" class="form-label">Father's Name *</label>
                                <input type="text" class="form-control @error('father_name') is-invalid @enderror" 
                                       id="father_name" name="father_name" value="{{ old('father_name') }}" required>
                                @error('father_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="mother_name" class="form-label">Mother's Name *</label>
                                <input type="text" class="form-control @error('mother_name') is-invalid @enderror" 
                                       id="mother_name" name="mother_name" value="{{ old('mother_name') }}" required>
                                @error('mother_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="parent_contact" class="form-label">Parent Contact Number *</label>
                            <input type="text" class="form-control @error('parent_contact') is-invalid @enderror" 
                                   id="parent_contact" name="parent_contact" value="{{ old('parent_contact') }}" required>
                            @error('parent_contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Register as Alumni
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
@endsection