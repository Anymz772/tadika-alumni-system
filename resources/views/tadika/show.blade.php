@extends('layouts.cms')

@section('title', $tadika->tadika_name . ' - Tadika Alumni CMS')
@section('page-title', 'Tadika Details')
@section('header-title', $tadika->tadika_name)
@section('header-subtitle', 'Registration: ' . $tadika->tadika_reg_no)

@section('header-buttons')
    <a href="{{ route('tadika.edit', $tadika->tadika_id) }}" class="btn btn-warning me-2">
        <i class="fas fa-edit me-2"></i> Edit
    </a>
    <a href="{{ route('tadika.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Back
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center pt-4">
                    @if($tadika->tadika_logo)
                    <img src="{{ asset('storage/' . $tadika->tadika_logo) }}"
                        alt="Tadika logo"
                        class="rounded mb-3"
                        style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                    <div class="bg-light rounded d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 150px; height: 150px;">
                        <i class="fas fa-school fa-4x text-primary"></i>
                    </div>
                    @endif
                    <h5 class="mt-3">{{ $tadika->tadika_name }}</h5>
                    <p class="text-muted small">Reg No: {{ $tadika->tadika_reg_no }}</p>
                    
                    <div class="alert alert-info small mt-3" role="alert">
                        <i class="fas fa-users me-2"></i>
                        <strong>Alumni Count:</strong> {{ $tadika->alumni->count() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tadika Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-secondary small text-uppercase mb-1">
                                <i class="fas fa-phone me-2"></i>Phone
                            </h6>
                            <p class="mb-0">{{ $tadika->tadika_phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-secondary small text-uppercase mb-1">
                                <i class="fas fa-envelope me-2"></i>Email
                            </h6>
                            <p class="mb-0">
                                <a href="mailto:{{ $tadika->tadika_email }}">{{ $tadika->tadika_email }}</a>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h6 class="text-secondary small text-uppercase mb-1">
                                <i class="fas fa-map-pin me-2"></i>Address
                            </h6>
                            <p class="mb-0">{{ $tadika->tadika_address }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-secondary small text-uppercase mb-1">
                                <i class="fas fa-location-dot me-2"></i>District
                            </h6>
                            <p class="mb-0">{{ $tadika->tadika_district }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-secondary small text-uppercase mb-1">
                                <i class="fas fa-map me-2"></i>State
                            </h6>
                            <p class="mb-0">{{ $tadika->tadika_state }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-secondary small text-uppercase mb-1">
                                <i class="fas fa-mailbox me-2"></i>Postcode
                            </h6>
                            <p class="mb-0">{{ $tadika->tadika_postcode }}</p>
                        </div>
                        @if($tadika->tadika_location)
                        <div class="col-md-6">
                            <h6 class="text-secondary small text-uppercase mb-1">
                                <i class="fas fa-location me-2"></i>Location
                            </h6>
                            <p class="mb-0">{{ $tadika->tadika_location }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($tadika->owner)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>Owner Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-secondary small text-uppercase mb-1">
                                <i class="fas fa-user me-2"></i>Owner Name
                            </h6>
                            <p class="mb-0">{{ $tadika->tadika_owner }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-secondary small text-uppercase mb-1">
                                <i class="fas fa-envelope me-2"></i>Email
                            </h6>
                            <p class="mb-0">
                                <a href="mailto:{{ $tadika->owner->user_email }}">{{ $tadika->owner->user_email }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($tadika->alumni->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Alumni from this Tadika ({{ $tadika->alumni->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Alumni Name</th>
                            <th>Email</th>
                            <th>Graduation Year</th>
                            <th>Company/Institution</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tadika->alumni->take(10) as $alumni)
                        <tr>
                            <td><strong>{{ $alumni->alumni_name }}</strong></td>
                            <td>{{ $alumni->alumni_email }}</td>
                            <td><span class="badge bg-primary">{{ $alumni->grad_year }}</span></td>
                            <td>
                                @if($alumni->alumni_status === 'working')
                                    {{ $alumni->company ?? 'Company not specified' }}
                                @elseif($alumni->alumni_status === 'studying')
                                    {{ $alumni->institution ?? 'Institution not specified' }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('alumni.show', $alumni->alumni_id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($tadika->alumni->count() > 10)
            <div class="alert alert-info small mt-3">
                <i class="fas fa-info-circle me-2"></i>
                Showing 10 of {{ $tadika->alumni->count() }} alumni. 
                <a href="{{ route('alumni.index', ['tadika_name' => $tadika->tadika_name]) }}" class="alert-link">View all</a>
            </div>
            @endif
        </div>
    </div>
    @endif
@endsection
