@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-user-circle me-2"></i>My Alumni Profile
                        </h4>
                        <div>
                            <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <div class="row">
                        <!-- Profile Header -->
                        <div class="col-md-12 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 80px; height: 80px;">
                                        <i class="fas fa-user-graduate fa-2x text-primary"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="mb-1">{{ $alumni->full_name }}</h3>
                                    <p class="text-muted mb-1">
                                        <i class="fas fa-graduation-cap me-1"></i>
                                        Graduated: {{ $alumni->year_graduated }}
                                    </p>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-envelope me-1"></i>
                                        {{ $alumni->email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Personal Information -->
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Personal Information</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Full Name:</strong><br>{{ $alumni->full_name }}</p>
                                    <p><strong>IC Number:</strong><br>{{ $alumni->ic_number ?? 'Not provided' }}</p>
                                    <p><strong>Contact Number:</strong><br>{{ $alumni->contact_number }}</p>
                                    <p><strong>Address:</strong><br>{{ $alumni->address ?? 'Not specified' }}</p>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Parents Information</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Father's Name:</strong><br>{{ $alumni->father_name }}</p>
                                    <p><strong>Mother's Name:</strong><br>{{ $alumni->mother_name }}</p>
                                    <p><strong>Parent Contact:</strong><br>{{ $alumni->parent_contact }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Professional Information -->
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-briefcase me-2"></i>Professional Information</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Current Workplace:</strong><br>{{ $alumni->current_workplace ?? 'Not specified' }}</p>
                                    <p><strong>Job Position:</strong><br>{{ $alumni->job_position ?? 'Not specified' }}</p>
                                    <p><strong>Graduation Year:</strong><br>{{ $alumni->year_graduated }}</p>
                                    <p><strong>Email:</strong><br>{{ $alumni->email }}</p>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-history me-2"></i>Profile Information</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Profile Created:</strong><br>{{ $alumni->created_at->format('d M Y, H:i') }}</p>
                                    <p><strong>Last Updated:</strong><br>{{ $alumni->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i> Edit Profile
                        </a>

                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-home me-2"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
