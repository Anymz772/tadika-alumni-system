@extends('layouts.cms')

@section('title', 'Manage Tadikas - Tadika Alumni CMS')
@section('page-title', 'Manage Tadikas')
@section('header-title', 'Tadika Management')
@section('header-subtitle', 'Manage all tadika records in the system')

@section('header-buttons')
<a href="{{ route('tadika.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i> Add New Tadika
</a>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
                    <span class="badge bg-primary">{{ $tadikas->total() }} Records Found</span>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('tadika.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Search Name/Email/Phone</label>
                        <input type="text" name="search" class="form-control"
                            value="{{ request('search') }}" placeholder="Search...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">District</label>
                        <input type="text" name="district" class="form-control"
                            value="{{ request('district') }}" placeholder="District name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control"
                            value="{{ request('state') }}" placeholder="State name">
                    </div>
                    <div class="col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i> Search
                        </button>
                        <a href="{{ route('tadika.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-2"></i> Reset
                        </a>
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
                <h5 class="mb-0"><i class="fas fa-school me-2"></i>Tadika List</h5>
            </div>

            <div class="card-body">
                @if($tadikas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tadika Information</th>
                                <th>Registration</th>
                                <th>Contact</th>
                                <th>Owner</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tadikas as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($tadikas->currentPage() - 1) * $tadikas->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-start">
                                        <div class="me-3">
                                            @if($item->tadika_logo)
                                            <img src="{{ asset('storage/' . $item->tadika_logo) }}"
                                                alt="Tadika logo"
                                                class="rounded"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-school text-primary fa-lg"></i>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <strong>{{ $item->tadika_name }}</strong>
                                            <div class="text-muted small">{{ $item->tadika_email }}</div>
                                            @if($item->tadika_location)
                                            <div class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> {{ $item->tadika_location }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info badge-status">{{ $item->tadika_reg_no }}</span>
                                </td>
                                <td>
                                    <div><i class="fas fa-phone text-muted me-2"></i>{{ $item->tadika_phone }}</div>
                                    @if($item->tadika_address)
                                    <div class="small text-muted"><i class="fas fa-map-marker-alt me-1"></i> {{ $item->tadika_district }}, {{ $item->tadika_state }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $item->tadika_owner }}</strong>
                                        <div class="small text-muted">
                                            @if($item->owner)
                                            {{ $item->owner->user_email }}
                                            @else
                                            <span class="text-danger">No owner assigned</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal{{ $item->tadika_id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <a href="{{ route('tadika.edit', $item->tadika_id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('tadika.destroy', $item->tadika_id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete {{ $item->tadika_name }}? This will also delete the owner account.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="quickViewModal{{ $item->tadika_id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tadika Details: {{ $item->tadika_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    @if($item->tadika_logo)
                                                    <img src="{{ asset('storage/' . $item->tadika_logo) }}"
                                                        alt="Tadika logo"
                                                        class="rounded mb-3"
                                                        style="width: 120px; height: 120px; object-fit: cover;">
                                                    @else
                                                    <div class="bg-light rounded d-inline-flex align-items-center justify-content-center mb-3"
                                                        style="width: 120px; height: 120px;">
                                                        <i class="fas fa-school fa-3x text-primary"></i>
                                                    </div>
                                                    @endif
                                                    <h5>{{ $item->tadika_name }}</h5>
                                                    <p class="text-muted">Reg No: {{ $item->tadika_reg_no }}</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <h6 class="fw-bold mb-3">Information</h6>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4"><strong>Phone:</strong></div>
                                                        <div class="col-sm-8">{{ $item->tadika_phone }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4"><strong>Email:</strong></div>
                                                        <div class="col-sm-8">{{ $item->tadika_email }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4"><strong>Address:</strong></div>
                                                        <div class="col-sm-8">{{ $item->tadika_address }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4"><strong>District:</strong></div>
                                                        <div class="col-sm-8">{{ $item->tadika_district }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4"><strong>State:</strong></div>
                                                        <div class="col-sm-8">{{ $item->tadika_state }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4"><strong>Postcode:</strong></div>
                                                        <div class="col-sm-8">{{ $item->tadika_postcode }}</div>
                                                    </div>
                                                    @if($item->tadika_location)
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4"><strong>Location:</strong></div>
                                                        <div class="col-sm-8">{{ $item->tadika_location }}</div>
                                                    </div>
                                                    @endif
                                                    <hr>
                                                    <h6 class="fw-bold mb-3">Owner Information</h6>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4"><strong>Owner Name:</strong></div>
                                                        <div class="col-sm-8">{{ $item->tadika_owner }}</div>
                                                    </div>
                                                    @if($item->owner)
                                                    <div class="row mb-2">
                                                        <div class="col-sm-4"><strong>Email:</strong></div>
                                                        <div class="col-sm-8">{{ $item->owner->user_email }}</div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('tadika.edit', $item->tadika_id) }}" class="btn btn-warning">
                                                <i class="fas fa-edit me-2"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-end">
                        {{ $tadikas->links() }}
                    </ul>
                </nav>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No tadikas found.</p>
                    <a href="{{ route('tadika.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-2"></i> Create First Tadika
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
