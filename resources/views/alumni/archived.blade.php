@extends('layouts.cms')

@section('title', 'Arsip Alumni - Tadika Alumni CMS')
@section('page-title', 'Arsip Alumni')
@section('header-title', 'Alumni yang Diarkibkan')
@section('header-subtitle', 'Padam sementara alumni - klik "Pulihkan" untuk mengembalikan ke senarai utama')

@section('header-buttons')
<a href="{{ route('alumni.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i> Kembali ke Senarai
</a>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i> Penapis</h5>
                    <span class="badge bg-secondary">{{ $alumni->total() }} Rekod Diarkibkan</span>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('alumni.archived') }}" class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Cari Nama/Email</label>
                        <input type="text" name="search" class="form-control"
                            value="{{ request('search') }}" placeholder="Cari...">
                    </div>
                    <div class="col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i> Cari
                        </button>
                        <a href="{{ route('alumni.archived') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-2"></i> Tetapkan Semula
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
            <div class="card-header bg-secondary">
                <h5 class="mb-0"><i class="fas fa-archive me-2"></i>Alumni Diarkibkan</h5>
            </div>

            <div class="card-body">
                @if($alumni->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Maklumat Alumni</th>
                                <th>Graduasi</th>
                                <th>Kenalan</th>
                                <th class="text-center">Tindakan</th>
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
                                            <div class="text-muted small">{{ $item->alumni_email }}</div>
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
                                    @if($item->alumni_state)
                                    <div class="small text-muted"><i class="fas fa-map-marker-alt me-1"></i> {{ $item->alumni_state }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons d-flex justify-content-center gap-2 flex-wrap">
                                        <form action="{{ route('alumni.unarchive', $item->alumni_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Pulihkan">
                                                <i class="fas fa-redo"></i> Pulihkan
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav>
                    {{ $alumni->links() }}
                </nav>
                @else
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Tiada Rekod</strong><br>
                    Tiada alumni yang diarkibkan.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
