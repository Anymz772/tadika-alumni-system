@extends('layouts.cms')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1">Papan Pemuka Tadika</h2>
            <p class="text-muted mb-0">
                Selamat datang, {{ auth()->user()->user_name }}.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <i class="fas fa-users fa-3x"></i>
                        <div class="text-end">
                            <div class="display-6 fw-bold">{{ $alumniCount }}</div>
                            <div class="small">Jumlah Alumni</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('tadika.alumni') }}" class="btn btn-sm btn-light flex-grow-1">Lihat Senarai</a>
                        <a href="{{ route('tadika.alumni.export') }}" class="btn btn-sm btn-light flex-grow-1" title="Muat Turun Excel"><i class="fas fa-file-excel me-1"></i> Export</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fas fa-user-plus fa-3x"></i>
                        <div class="text-end">
                            <div class="display-6 fw-bold">{{ $newAlumniCount }}</div>
                            <div class="small">Pendaftaran Bulan Ini</div>
                        </div>
                    </div>
                    <div class="text-end small mt-3 opacity-75">Alumni baharu bulan ini</div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-white bg-info shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center">
                        <i class="fas fa-bolt fa-3x"></i>
                        <div class="text-end fw-bold">Tindakan</div>
                    </div>
                    <div class="mt-auto">
                        <a href="{{ route('tadika.alumni.message_all.form') }}" class="btn btn-light btn-sm mt-3 text-start w-100">
                            <i class="fas fa-envelope me-2"></i> Mesej Semua Alumni
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-building me-2"></i>Profil Tadika</h5>
                    <a href="{{ route('tadika.profile.edit') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit me-1"></i> Sunting Profil
                    </a>
                </div>
                <div class="card-body">
                    @if($tadika)
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <strong class="text-muted d-block mb-1">Nama Tadika:</strong>
                                {{ $tadika->tadika_name }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong class="text-muted d-block mb-1">No. Pendaftaran:</strong>
                                {{ $tadika->tadika_reg_no }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong class="text-muted d-block mb-1">E-mel:</strong>
                                {{ $tadika->tadika_email ?? '-' }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong class="text-muted d-block mb-1">Lokasi:</strong>
                                {{ $tadika->tadika_district }}, {{ $tadika->tadika_state }} {{ $tadika->tadika_postcode }}
                            </div>
                        </div>
                    @else
                        <p class="text-muted mb-0 py-3 text-center">Tiada profil Tadika ditemui lagi.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
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
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-chart-pie me-2"></i>Status Alumni</h5>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <canvas id="statusChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-8 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-chart-bar me-2"></i>Statistik Tahun Graduasi</h5>
                </div>
                <div class="card-body">
                    <canvas id="gradYearChart" style="max-height: 250px;"></canvas>
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
        // 1. Initialize Doughnut Chart (Status: Studying vs Working)
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Belajar (Studying)', 'Bekerja (Working)'],
                datasets: [{
                    data: [{{ $statusChartData['studying'] }}, {{ $statusChartData['working'] }}],
                    backgroundColor: [
                        '#0dcaf0', // Info Blue for Studying
                        '#198754'  // Success Green for Working
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // 2. Initialize Bar Chart (Alumni by Graduation Year)
        const ctxGradYear = document.getElementById('gradYearChart').getContext('2d');
        new Chart(ctxGradYear, {
            type: 'bar',
            data: {
                labels: {!! json_encode($gradYearLabels) !!},
                datasets: [{
                    label: 'Jumlah Alumni',
                    data: {!! json_encode($gradYearValues) !!},
                    backgroundColor: '#0d6efd', // Primary Blue
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Ensure the Y axis shows whole numbers only
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Hide legend since there's only one dataset
                    }
                }
            }
        });
    });
</script>
@endpush