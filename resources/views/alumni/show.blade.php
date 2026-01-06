@extends('layouts.cms')

@section('title', 'Alumni Details - ' . $alumni->full_name)
@section('page-title', 'Alumni Details')
@section('header-title', $alumni->full_name)
@section('header-subtitle', 'Graduated: ' . $alumni->year_graduated)

@section('header-buttons')
<div class="btn-group">
    <a href="{{ route('alumni.edit', $alumni->id) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i> Edit
    </a>
    <a href="{{ route('alumni.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Back
    </a>
</div>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

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
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Email:</strong><br>{{ $alumni->email }}</p>
                        <p><strong>Contact Number:</strong><br>{{ $alumni->contact_number }}</p>
                        <p><strong>IC Number:</strong><br>{{ $alumni->ic_number ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Workplace:</strong><br>{{ $alumni->current_workplace ?? 'N/A' }}</p>
                        <p><strong>Position:</strong><br>{{ $alumni->job_position ?? 'N/A' }}</p>
                        <p><strong>Address:</strong><br>{{ $alumni->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Actions</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h6 class="text-warning">Reset Password</h6>
                                @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <form action="{{ route('alumni.reset-password', $alumni->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="password" name="password" class="form-control" placeholder="New password" required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" required>
                                    </div>
                                    <button type="submit" class="btn btn-warning w-100">Reset Password</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-danger">
                            <div class="card-body">
                                <h6 class="text-danger">Delete Account</h6>
                                <form action="{{ route('alumni.destroy', $alumni->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this alumni?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-trash me-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection