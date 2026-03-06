@extends('layouts.cms')

@section('title', 'Papan Pemuka - Tadika Alumni CMS')
@section('page-title', 'Papan Pemuka')
@section('header-title', 'Papan Pemuka CMS')
@section('header-subtitle', 'Selamat kembali, ' . Auth::user()->user_name)

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x"></i>
                    <div class="count mt-2">{{ $stats['total_alumni'] }}</div>
                    <div class="label">Jumlah Alumni</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-user-check fa-2x"></i>
                    <div class="count mt-2">{{ $stats['total_users'] }}</div>
                    <div class="label">Jumlah Pengguna</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-2x"></i>
                    <div class="count mt-2">{{ $stats['recent_alumni'] }}</div>
                    <div class="label">Baru Tahun Ini</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x"></i>
                    <div class="count mt-2">{{ $stats['alumni_by_year']->count() }}</div>
                    <div class="label">Tahun Graduasi</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Alumni Terkini</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tahun Graduasi</th>
                                    <th>Syarikat/Institusi</th>
                                    <th>Foto</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentAlumni as $alumni)
                                    <tr>
                                        <td><strong>{{ $alumni->alumni_name }}</strong><br><small>{{ $alumni->alumni_email }}</small>
                                        </td>
                                        <td>{{ $alumni->grad_year }}</td>
                                        <td>
                                            @if ($alumni->alumni_status === 'working')
                                                {{ $alumni->company ?? 'Syarikat tidak ditetapkan' }}
                                            @elseif($alumni->alumni_status === 'studying')
                                                {{ $alumni->institution ?? 'Institusi tidak ditetapkan' }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @if($alumni->photo_childhood)
                                                    <img src="{{ asset('storage/' . $alumni->photo_childhood) }}" alt="Childhood Photo" class="img-fluid rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                                @if($alumni->photo_current)
                                                    <img src="{{ asset('storage/' . $alumni->photo_current) }}" alt="Current Photo" class="img-fluid rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('alumni.show', $alumni->alumni_id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('alumni.edit', $alumni->alumni_id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Tahun Graduasi</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($stats['alumni_by_year'] as $year)
                            <li class="list-group-item d-flex justify-content-between">
                                {{ $year->grad_year }}
                                <span class="badge bg-primary">{{ $year->count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Tindakan</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('alumni.create') }}" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-user-plus me-2"></i> Tambah Alumni Baru
                    </a>
                    <a href="{{ route('alumni.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-list me-2"></i> Lihat Semua Alumni
                    </a>
                    <a href="{{ route('admin.alumni.export') }}" class="btn btn-success w-100 mt-2">
                        <i class="fas fa-file-excel me-2"></i> Export Semua Alumni
                    </a>
                    <a href="{{ route('admin.tadika.export') }}" class="btn btn-info w-100 mt-2">
                        <i class="fas fa-file-excel me-2"></i> Export Senarai Tadika
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
