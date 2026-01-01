@extends('layouts.cms')

@section('title', 'Add New Alumni')
@section('page-title', 'Add Alumni')
@section('header-title', 'Add New Alumni')

@section('header-buttons')
<a href="{{ route('alumni.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i> Back
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Add New Alumni</h5>
    </div>
    
    <form method="POST" action="{{ route('alumni.store') }}">
        @csrf
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Contact Number *</label>
                        <input type="text" class="form-control" name="contact_number" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Year Graduated *</label>
                        <input type="number" class="form-control" name="year_graduated" min="2000" max="{{ date('Y') }}" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Login Name *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password *</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">IC Number</label>
                        <input type="text" class="form-control" name="ic_number">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Current Workplace</label>
                        <input type="text" class="form-control" name="current_workplace">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Job Position</label>
                        <input type="text" class="form-control" name="job_position">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control" name="address" rows="2"></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Father's Name *</label>
                        <input type="text" class="form-control" name="father_name" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Mother's Name *</label>
                        <input type="text" class="form-control" name="mother_name" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Parent Contact *</label>
                <input type="text" class="form-control" name="parent_contact" required>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Create Alumni
            </button>
        </div>
    </form>
</div>
@endsection