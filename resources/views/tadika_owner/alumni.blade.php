@extends('layouts.cms')

@section('title', 'Senarai Alumni - ' . $tadika->tadika_name)
@section('page-title', 'Senarai Alumni')
@section('header-title', 'Senarai Alumni')
@section('header-subtitle', 'Senarai semua alumni berdaftar untuk ' . $tadika->tadika_name)

@section('header-buttons')
    <a href="{{ route('tadika.dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Papan Pemuka
    </a>
@endsection

@section('content')

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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Senarai Alumni</h5>
                <span class="badge bg-primary">{{ $alumni->total() }} Rekod Ditemui</span>
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
                                <th>Pekerjaan/Pengajian</th>
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
                                            <div class="text-muted small">{{ $item->user->user_email ?? $item->alumni_email }}</div>
                                            @if($item->alumni_ic)
                                            <div class="text-muted small">IC: {{ $item->alumni_ic }}</div>
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
                                    @if($item->alumni_status === 'studying')
                                    <div><strong>{{ $item->institution ?? 'Institusi tidak ditetapkan' }}</strong></div>
                                    <div class="small text-muted"><span class="badge bg-info"><i class="fas fa-graduation-cap me-1"></i> Sedang belajar</span></div>
                                    @elseif($item->alumni_status === 'working')
                                    <div><strong>{{ $item->company ?? 'Syarikat tidak ditetapkan' }}</strong></div>
                                    <div class="small text-muted">{{ $item->job_position ?? 'Jawatan tidak ditetapkan' }}</div>
                                    <div class="small text-muted"><span class="badge bg-success"><i class="fas fa-briefcase me-1"></i> Bekerja</span></div>
                                    @else
                                    <span class="text-muted">Tidak ditetapkan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('alumni.show', $item->alumni_id) }}" class="btn btn-sm btn-info" title="Lihat Profil Penuh">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('tadika.alumni.edit', $item->alumni_id) }}" class="btn btn-sm btn-warning" title="Sunting">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('tadika.alumni.message.form', $item->alumni_id) }}" class="btn btn-sm btn-secondary" title="Hantar Mesej">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($alumni->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3 small">
                    <div class="text-muted">
                        Menunjukkan {{ $alumni->firstItem() }}–{{ $alumni->lastItem() }}
                        daripada {{ $alumni->total() }}
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
                    <h4 class="text-muted">Tiada Alumni Ditemui</h4>
                    <p class="text-muted">Apabila alumni mendaftar untuk tadika anda, mereka akan muncul di sini.</p>
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
</style>
@endpush