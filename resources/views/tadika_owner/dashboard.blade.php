@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1">Papan Pemuka Tadika</h2>
            <p class="text-muted mb-0">
                Selamat datang, {{ auth()->user()->user_name }}.
            </p>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('tadika.alumni') }}" class="text-decoration-none">
                <div class="card stat-card bg-primary text-white h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x"></i>
                        <div class="display-6 fw-bold mt-2">{{ $alumniCount }}</div>
                        <div class="small">Jumlah Alumni</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card bg-success text-white h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-plus fa-3x"></i>
                    <div class="display-6 fw-bold mt-2">{{ $newAlumniCount }}</div>
                    <div class="small">Pendaftaran Bulan Ini</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('tadika.alumni.message_all.form') }}" class="text-decoration-none">
                <div class="card stat-card bg-warning text-white h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-envelope fa-3x"></i>
                        <div class="display-6 fw-bold mt-2">&nbsp;</div>
                        <div class="small">Mesej Semua</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('tadika.alumni.export') }}" class="text-decoration-none">
                <div class="card stat-card bg-danger text-white h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-file-excel fa-3x"></i>
                        <div class="display-6 fw-bold mt-2">&nbsp;</div>
                        <div class="small">Export Data</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-chart-bar me-2"></i>Statistik Tahun Graduasi</h5>
                </div>
                <div class="card-body">
                    <canvas id="gradYearChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-chart-pie me-2"></i>Status Alumni</h5>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <canvas id="statusChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Alumni and Tadika Profile -->
    <div class="row mb-4">
        <div class="col-md-8 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-history me-2"></i>Pendaftaran Terkini</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($recentAlumni as $alumnus)
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h6 class="mb-0">{{ $alumnus->alumni_name }}</h6>
                                    <small class="text-muted">Sesi {{ $alumnus->grad_year ?? '-' }}</small>
                                </div>
                                <span class="badge {{ $alumnus->alumni_status === 'working' ? 'bg-success' : 'bg-info' }} rounded-pill">
                                    {{ ucfirst($alumnus->alumni_status) }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-4">Belum ada alumni berdaftar.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-building me-2"></i>Profil Tadika</h5>
                    <a href="{{ route('tadika.profile.edit') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit me-1"></i> Sunting
                    </a>
                </div>
                <div class="card-body">
                    @if($tadika)
                        <div class="small">
                            <strong class="text-muted d-block mb-1">Nama Tadika:</strong>
                            <p>{{ $tadika->tadika_name }}</p>
                            
                            <strong class="text-muted d-block mb-1">No. Pendaftaran:</strong>
                             <p>{{ $tadika->tadika_reg_no }}</p>

                            <strong class="text-muted d-block mb-1">E-mel:</strong>
                            <p>{{ $tadika->tadika_email ?? '-' }}</p>

                            <strong class="text-muted d-block mb-1">Lokasi:</strong>
                            <p>{{ $tadika->tadika_district }}, {{ $tadika->tadika_state }}</p>
                        </div>
                    @else
                        <p class="text-muted mb-0 py-3 text-center">Tiada profil Tadika ditemui lagi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Doughnut Chart for Status
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Belajar', 'Bekerja'],
                datasets: [{
                    data: [{{ $statusChartData['studying'] }}, {{ $statusChartData['working'] }}],
                    backgroundColor: ['#0dcaf0', '#198754'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // 2. Bar Chart for Graduation Year
        const ctxGradYear = document.getElementById('gradYearChart').getContext('2d');
        new Chart(ctxGradYear, {
            type: 'bar',
            data: {
                labels: {!! json_encode($gradYearLabels) !!},
                datasets: [{
                    label: 'Jumlah Alumni',
                    data: {!! json_encode($gradYearValues) !!},
                    backgroundColor: '#0d6efd',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endpush