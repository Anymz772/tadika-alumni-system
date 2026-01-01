@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-user-edit me-2"></i>Edit My Profile
                        </h4>
                        <div>
                            <a href="{{ route('profile.show') }}" class="btn btn-dark btn-sm">
                                <i class="fas fa-eye me-1"></i> View Profile
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <h5 class="mb-3 text-primary">Personal Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="full_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" name="full_name" 
                                       value="{{ old('full_name', $alumni->full_name) }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="ic_number" class="form-label">IC Number</label>
                                <input type="text" class="form-control @error('ic_number') is-invalid @enderror" 
                                       id="ic_number" name="ic_number" 
                                       value="{{ old('ic_number', $alumni->ic_number) }}">
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
                                       min="2000" max="{{ date('Y') }}" 
                                       value="{{ old('year_graduated', $alumni->year_graduated) }}" required>
                                @error('year_graduated')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contact_number" class="form-label">Contact Number *</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" 
                                       id="contact_number" name="contact_number" 
                                       value="{{ old('contact_number', $alumni->contact_number) }}" required>
                                @error('contact_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <h5 class="mb-3 text-primary mt-4">Professional Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="current_workplace" class="form-label">Current Workplace</label>
                                <input type="text" class="form-control" 
                                       id="current_workplace" name="current_workplace" 
                                       value="{{ old('current_workplace', $alumni->current_workplace) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="job_position" class="form-label">Job Position</label>
                                <input type="text" class="form-control" 
                                       id="job_position" name="job_position" 
                                       value="{{ old('job_position', $alumni->job_position) }}">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" 
                                      rows="3">{{ old('address', $alumni->address) }}</textarea>
                        </div>
                        
                        <h5 class="mb-3 text-primary mt-4">Parents Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="father_name" class="form-label">Father's Name *</label>
                                <input type="text" class="form-control @error('father_name') is-invalid @enderror" 
                                       id="father_name" name="father_name" 
                                       value="{{ old('father_name', $alumni->father_name) }}" required>
                                @error('father_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="mother_name" class="form-label">Mother's Name *</label>
                                <input type="text" class="form-control @error('mother_name') is-invalid @enderror" 
                                       id="mother_name" name="mother_name" 
                                       value="{{ old('mother_name', $alumni->mother_name) }}" required>
                                @error('mother_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="parent_contact" class="form-label">Parent Contact Number *</label>
                            <input type="text" class="form-control @error('parent_contact') is-invalid @enderror" 
                                   id="parent_contact" name="parent_contact" 
                                   value="{{ old('parent_contact', $alumni->parent_contact) }}" required>
                            @error('parent_contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection