@extends('layouts.cms')

@section('title', 'My Alumni Profile')
@section('page-title', 'My Profile')
@section('header-title', 'My Alumni Profile')
@section('header-subtitle', 'View and manage your alumni information')



@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                @if($alumni->photo)
                <img src="{{ asset('storage/' . $alumni->photo) }}"
                    alt="Profile Photo"
                    class="rounded-circle mb-3"
                    style="width: 100px; height: 100px; object-fit: cover;">
                @else
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 100px; height: 100px;">
                    <i class="fas fa-user-graduate fa-3x text-primary"></i>
                </div>
                @endif
                <h4>{{ $alumni->full_name }}</h4>
                <p class="text-muted">{{ $alumni->job_position ?? 'Alumni' }}</p>
                <div class="mt-2">
                    <span class="badge bg-primary">{{ $alumni->year_graduated }} Graduate</span>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-users me-2"></i>Parents</h6>
            </div>
            <div class="card-body">
                <p><strong>Father:</strong> {{ $alumni->father_name }}</p>
                <p><strong>Mother:</strong> {{ $alumni->mother_name }}</p>
                <p><strong>Contact:</strong> {{ $alumni->parent_contact }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Profile Details</h6>
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
                    <div class="col-md-6">
                        <p><strong>Email:</strong><br>{{ $alumni->email }}</p>
                        <p><strong>Contact Number:</strong><br>{{ $alumni->contact_number }}</p>
                        <p><strong>IC Number:</strong><br>{{ $alumni->ic_number ?? 'N/A' }}</p>
                        <p><strong>Age:</strong><br>{{ $alumni->age ?? 'N/A' }}</p>
                        <p><strong>Gender:</strong><br>{{ ucfirst($alumni->gender) ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Current Status:</strong><br>
                            @if($alumni->current_status === 'studying')
                            <span class="badge bg-info"><i class="fas fa-graduation-cap me-1"></i> Studying</span>
                            @elseif($alumni->current_status === 'working')
                            <span class="badge bg-success"><i class="fas fa-briefcase me-1"></i> Working</span>
                            @else
                            N/A
                            @endif
                        </p>
                        @if($alumni->current_status === 'studying')
                        <p><strong>Institution:</strong><br>{{ $alumni->institution_name ?? 'N/A' }}</p>
                        @elseif($alumni->current_status === 'working')
                        <p><strong>Company:</strong><br>{{ $alumni->company_name ?? 'N/A' }}</p>
                        <p><strong>Position:</strong><br>{{ $alumni->job_position ?? 'N/A' }}</p>
                        @endif
                        <p><strong>Tadika Name:</strong><br>{{ $alumni->tadika_name ?? 'N/A' }}</p>
                        <p><strong>State:</strong><br>{{ $alumni->state ?? 'N/A' }}</p>
                        <p><strong>Address:</strong><br>{{ $alumni->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            @if($alumni->created_at)
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-calendar-plus me-1"></i>
                            Profile Created: {{ $alumni->created_at->format('d M Y, H:i') }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="fas fa-calendar-check me-1"></i>
                            Last Updated: {{ $alumni->updated_at->format('d M Y, H:i') }}
                        </small>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning w-100">
                            <i class="fas fa-edit me-2"></i> Edit Profile
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary w-100">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection