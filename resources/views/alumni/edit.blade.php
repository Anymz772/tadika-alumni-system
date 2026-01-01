@extends('layouts.cms')

@section('title', 'Edit Alumni - ' . $alumni->full_name)
@section('page-title', 'Edit Alumni')
@section('header-title', 'Edit: ' . $alumni->full_name)

@section('header-buttons')
<a href="{{ route('alumni.show', $alumni->id) }}" class="btn btn-info me-2">
    <i class="fas fa-eye me-2"></i> View
</a>
<a href="{{ route('alumni.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i> Back
</a>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Alumni</h5>
    </div>
    
    <form method="POST" action="{{ route('alumni.update', $alumni->id) }}">
        @csrf
        @method('PUT')
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control" name="full_name" 
                               value="{{ old('full_name', $alumni->full_name) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" 
                               value="{{ old('email', $alumni->email) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Contact Number *</label>
                        <input type="text" class="form-control" name="contact_number" 
                               value="{{ old('contact_number', $alumni->contact_number) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Year Graduated *</label>
                        <input type="number" class="form-control" name="year_graduated" 
                               value="{{ old('year_graduated', $alumni->year_graduated) }}" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Current Workplace</label>
                        <input type="text" class="form-control" name="current_workplace" 
                               value="{{ old('current_workplace', $alumni->current_workplace) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Job Position</label>
                        <input type="text" class="form-control" name="job_position" 
                               value="{{ old('job_position', $alumni->job_position) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">IC Number</label>
                        <input type="text" class="form-control" name="ic_number" 
                               value="{{ old('ic_number', $alumni->ic_number) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="2">{{ old('address', $alumni->address) }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Father's Name *</label>
                        <input type="text" class="form-control" name="father_name" 
                               value="{{ old('father_name', $alumni->father_name) }}" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Mother's Name *</label>
                        <input type="text" class="form-control" name="mother_name" 
                               value="{{ old('mother_name', $alumni->mother_name) }}" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Parent Contact *</label>
                <input type="text" class="form-control" name="parent_contact" 
                       value="{{ old('parent_contact', $alumni->parent_contact) }}" required>
            </div>
        </div>
        
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <a href="{{ route('alumni.show', $alumni->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Update
                </button>
            </div>
        </div>
    </form>
</div>
@endsection