@extends('layouts.cms')

@section('title', 'Manage Alumni - Tadika Alumni CMS')
@section('page-title', 'Manage Alumni')
@section('header-title', 'Alumni Management')
@section('header-subtitle', 'Manage all alumni records in the system')

@section('header-buttons')
<a href="{{ route('alumni.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i> Add New Alumni
</a>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
                    <span class="badge bg-primary">{{ $alumni->total() }} Records Found</span>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('alumni.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Search Name/Email</label>
                        <input type="text" name="search" class="form-control"
                            value="{{ request('search') }}" placeholder="Search...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Graduation Year From</label>
                        <input type="number" name="year_from" class="form-control"
                            value="{{ request('year_from') }}" placeholder="e.g., 2010" min="2000" max="{{ date('Y') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Graduation Year To</label>
                        <input type="number" name="year_to" class="form-control"
                            value="{{ request('year_to') }}" placeholder="e.g., 2020" min="2000" max="{{ date('Y') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Workplace</label>
                        <input type="text" name="workplace" class="form-control"
                            value="{{ request('workplace') }}" placeholder="Company name">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i> Search
                            </button>
                            <a href="{{ route('alumni.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-2"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Alumni List</h5>
            </div>

            <div class="card-body">
                @if($alumni->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Alumni Information</th>
                                <th>Graduation</th>
                                <th>Contact</th>
                                <th>Workplace</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumni as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($alumni->currentPage() - 1) * $alumni->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-start">
                                        <div class="me-3">
                                            @if($item->alumni_photo)
                                            <img src="{{ asset('storage/' . $item->alumni_photo) }}"
                                                alt="Profile photo"
                                                class="rounded-circle"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-user-graduate text-primary"></i>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <strong>{{ $item->alumni_name }}</strong>
                                            <div class="text-muted small">{{ $item->user_email }}</div>
                                            @if($item->alumni_ic)
                                            <div class="text-muted small">IC: {{ $item->alumni_ic }}</div>
                                            @endif
                                            @if($item->tadika_name)
                                            <div class="text-muted small"><i class="fas fa-school me-1"></i> {{ $item->tadika_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary badge-status">{{ $item->grad_year }}</span>
                                </td>
                                <td>
                                    <div><i class="fas fa-phone text-muted me-2"></i>{{ $item->alumni_phone }}</div>
                                    @if($item->parent_phone)
                                    <div class="small text-muted">Parent: {{ $item->parent_phone }}</div>
                                    @endif
                                    @if($item->alumni_state)
                                    <div class="small text-muted"><i class="fas fa-map-marker-alt me-1"></i> {{ $item->alumni_state }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($item->alumni_status === 'studying')
                                    <div><strong>{{ $item->institution ?? 'Institution not specified' }}</strong></div>
                                    <div class="small text-muted"><span class="badge bg-info"><i class="fas fa-graduation-cap me-1"></i> Studying</span></div>
                                    @elseif($item->alumni_status === 'working')
                                    <div><strong>{{ $item->company ?? 'Company not specified' }}</strong></div>
                                    <div class="small text-muted">{{ $item->job_position ?? 'Position not specified' }}</div>
                                    <div class="small text-muted"><span class="badge bg-success"><i class="fas fa-briefcase me-1"></i> Working</span></div>
                                    @else
                                    <span class="text-muted">Not specified</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal{{ $item->alumni_id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <a href="{{ route('alumni.edit', $item->alumni_id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('alumni.destroy', $item->alumni_id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete {{ $item->alumni_name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="quickViewModal{{ $item->alumni_id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Alumni Details: {{ $item->alumni_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    @if($item->alumni_photo)
                                                    <img src="{{ asset('storage/' . $item->alumni_photo) }}"
                                                        alt="Profile photo"
                                                        class="rounded-circle mb-3"
                                                        style="width: 100px; height: 100px; object-fit: cover;">
                                                    @else
                                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                        style="width: 100px; height: 100px;">
                                                        <i class="fas fa-user-graduate fa-3x text-primary"></i>
                                                    </div>
                                                    @endif
                                                    <h5>{{ $item->alumni_name }}</h5>
                                                    <p class="text-muted">{{ $item->job_position ?? 'Alumni' }}</p>

                                                    <div class="mt-3">
                                                        <span class="badge bg-primary">{{ $item->grad_year }} Graduate</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="text-primary">Contact Information</h6>
                                                            <p><i class="fas fa-envelope me-2 text-muted"></i>{{ $item->user_email }}</p>
                                                            <p><i class="fas fa-phone me-2 text-muted"></i>{{ $item->alumni_phone }}</p>
                                                            <p><i class="fas fa-map-marker-alt me-2 text-muted"></i>{{ $item->alumni_state ?? 'State not specified' }}</p>
                                                            <p><i class="fas fa-map-marker-alt me-2 text-muted"></i>{{ $item->alumni_address ?? 'Address not specified' }}</p>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <h6 class="text-primary">Professional Information</h6>
                                                            <p><i class="fas fa-info-circle me-2 text-muted"></i>
                                                                @if($item->alumni_status === 'studying')
                                                                <span class="badge bg-info"><i class="fas fa-graduation-cap me-1"></i> Studying</span>
                                                                @elseif($item->alumni_status === 'working')
                                                                <span class="badge bg-success"><i class="fas fa-briefcase me-1"></i> Working</span>
                                                                @else
                                                                Not specified
                                                                @endif
                                                            </p>
                                                            @if($item->alumni_status === 'studying')
                                                            <p><i class="fas fa-graduation-cap me-2 text-muted"></i>{{ $item->institution ?? 'Institution not specified' }}</p>
                                                            @elseif($item->alumni_status === 'working')
                                                            <p><i class="fas fa-building me-2 text-muted"></i>{{ $item->company ?? 'Company not specified' }}</p>
                                                            <p><i class="fas fa-user-tie me-2 text-muted"></i>{{ $item->job_position ?? 'Position not specified' }}</p>
                                                            @endif
                                                            <p><i class="fas fa-school me-2 text-muted"></i>{{ $item->tadika_name ?? 'Tadika not specified' }}</p>
                                                            <p><i class="fas fa-birthday-cake me-2 text-muted"></i>{{ $item->age ? $item->age . ' years old' : 'Age not specified' }}</p>
                                                            <p><i class="fas fa-id-card me-2 text-muted"></i>{{ $item->alumni_ic ?? 'IC not provided' }}</p>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="text-primary">Parents Information</h6>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p><strong>Father:</strong><br>{{ $item->father_name }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>Mother:</strong><br>{{ $item->mother_name }}</p>
                                                                </div>
                                                            </div>
                                                            <p><strong>Parent Contact:</strong><br>{{ $item->parent_phone }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('alumni.edit', $item->alumni_id) }}" class="btn btn-warning">
                                                <i class="fas fa-edit me-2"></i> Edit Profile
                                            </a>
                                            <a href="{{ route('alumni.show', $item->alumni_id) }}" class="btn btn-primary">
                                                <i class="fas fa-external-link-alt me-2"></i> Full Details
                                            </a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($alumni->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3 small">
                    <div class="text-muted">
                        Showing {{ $alumni->firstItem() }}–{{ $alumni->lastItem() }}
                        of {{ $alumni->total() }}
                    </div>

                    <div>
                        {{ $alumni->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif

                @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-muted"></i>
                    </div>
                    <h4 class="text-muted">No Alumni Found</h4>
                    <p class="text-muted">Start by adding your first alumni record.</p>
                    <a href="{{ route('alumni.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-2"></i> Add First Alumni
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .action-buttons .btn {
        padding: 5px 10px;
        margin-right: 5px;
    }
    .action-buttons .btn:last-child {
        margin-right: 0;
    }
    .modal-body p {
        margin-bottom: 10px;
    }
</style>
@endpush