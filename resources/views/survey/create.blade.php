@extends('layouts.public')

@section('title', 'Alumni Registration - Tadika Alumni System')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="survey-container">
            <div class="text-center mb-5">
                <h2 class="mb-3"><i class="fas fa-user-plus me-2"></i>Alumni Registration Form</h2>
                <p class="text-muted">Please fill in your details to join the Tadika Alumni Network</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> Please fix the errors below.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('survey.store') }}">
                @csrf
                
                <!-- Step 1: Personal Information -->
                <div class="form-section">
                    <h5><i class="fas fa-user me-2"></i>Personal Information</h5>
                    
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
                            <label for="ic_number" class="form-label">IC Number</label>
                            <input type="text" class="form-control @error('ic_number') is-invalid @enderror" 
                                   id="ic_number" name="ic_number" value="{{ old('ic_number') }}">
                            @error('ic_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="year_graduated" class="form-label required">Year Graduated</label>
                            <input type="number" class="form-control @error('year_graduated') is-invalid @enderror" 
                                   id="year_graduated" name="year_graduated" 
                                   min="2000" max="{{ date('Y') }}" value="{{ old('year_graduated') }}" required>
                            @error('year_graduated')
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
                            <label for="contact_number" class="form-label required">Contact Number</label>
                            <input type="text" class="form-control @error('contact_number') is-invalid @enderror" 
                                   id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required>
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2: Professional Information -->
                <div class="form-section">
                    <h5><i class="fas fa-briefcase me-2"></i>Professional Information</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="current_workplace" class="form-label">Current Workplace</label>
                            <input type="text" class="form-control" 
                                   id="current_workplace" name="current_workplace" value="{{ old('current_workplace') }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="job_position" class="form-label">Job Position</label>
                            <input type="text" class="form-control" 
                                   id="job_position" name="job_position" value="{{ old('job_position') }}">
                        </div>
                    </div>
                </div>
                
                <!-- Step 3: Parents Information -->
                <div class="form-section">
                    <h5><i class="fas fa-users me-2"></i>Parents Information</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="father_name" class="form-label">Father's Name</label>
                            <input type="text" class="form-control" 
                                   id="father_name" name="father_name" value="{{ old('father_name') }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="mother_name" class="form-label">Mother's Name</label>
                            <input type="text" class="form-control" 
                                   id="mother_name" name="mother_name" value="{{ old('mother_name') }}">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="parent_contact" class="form-label">Parent Contact Number</label>
                        <input type="text" class="form-control" 
                               id="parent_contact" name="parent_contact" value="{{ old('parent_contact') }}">
                    </div>
                </div>
                
                <!-- Terms and Submit -->
                <div class="form-section">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> 
                        You will receive login credentials via email once approved.
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
                            <i class="fas fa-paper-plane me-2"></i> Submit Registration
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
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
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