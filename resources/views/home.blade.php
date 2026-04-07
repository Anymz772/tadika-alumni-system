@extends('layouts.public')

@section('title', 'Laman Utama - Sistem Alumni Tadika')
@section('content')
<div class="row align-items-center mb-5">
    <div class="col-md-6">
        <h1 class="display-4 fw-bold mb-4">Selamat datang ke Rangkaian Alumni</h1>
        <p class="lead mb-4">
            Sambungkan semula dengan rakan sekelas anda, kekal dikemaskini dengan berita tadika,
            dan jadilah sebahagian daripada komuniti alumni kami yang berkembang. Perjalanan anda berterusan di sini.
        </p>
        <div class="d-flex gap-3">
            <a href="{{ route('alumni.register') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-user-plus me-2"></i> Daftar Alumni
            </a>
            <a href="{{ route('tadika.register') }}" class="btn btn-outline-success btn-lg">
                <i class="fas fa-school me-2"></i> Daftar Tadika
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0">
            <div class="card-body text-center p-5">
                <i class="fas fa-graduation-cap fa-6x text-primary mb-4"></i>
                <h3 class="mb-3">Portal Rasmi Alumni</h3>
                <p class="text-muted">
                    Platform eksklusif untuk graduan Tadika berhubung, berkongsi peluang,
                    dan menyertai acara alumni.
                </p>
            </div>
        </div>
    </div>
</div>


<!-- Statistik -->
<div class="row mb-5">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Rangkaian Alumni</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6 mb-3">
                        <div class="display-4 fw-bold text-success">
                            {{ $totalTadikas }}
                        </div>
                        <p class="text-muted mb-0">Jumlah Tadika Berdaftar</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="display-4 fw-bold text-info">
                            {{ $totalAlumni }}
                        </div>
                        <p class="text-muted mb-0">Jumlah Keseluruhan Alumni</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Senarai Tadika -->
<div class="row mb-5">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0"><i class="fas fa-school me-2"></i>Tadika Berdaftar  </h4>
                </div>
                <a href="{{ route('tadikas.public.index') }}" class="btn btn-outline-light btn-sm">
                    Lihat Lanjut <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Tadika</th>
                                <th>Daerah</th>
                                <th>Negeri</th>
                                <th>Tahun Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTadikas as $item)
                                <tr>
                                    <td>{{ $item->tadika_name }}</td>
                                    <td>{{ $item->tadika_district }}</td>
                                    <td>{{ $item->tadika_state }}</td>
                                    <td>{{ optional($item->created_at)->year ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Tiada tadika berdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ciri-ciri -->
<div class="row">
    <div class="col-md-12">
        <h3 class="mb-4 text-center">Mengapa Sertai sebagai Alumni?</h3>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-network-wired fa-3x text-primary"></i>
                        </div>
                        <h5>Peluang Rangkaian</h5>
                        <p class="text-muted">
                            Berhubung dengan alumni dalam pelbagai industri dan bina hubungan profesional.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-briefcase fa-3x text-success"></i>
                        </div>
                        <h5>Pembangunan Kerjaya</h5>
                        <p class="text-muted">
                            Akses peluang kerja, program bimbingan, dan panduan kerjaya daripada alumni senior.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-hands-helping fa-3x text-warning"></i>
                        </div>
                        <h5>Menyumbang kepada Tadika</h5>
                        <p class="text-muted">
                            Sertai acara tadika, bimbing pelajar semasa, dan sumbang kepada pembangunan tadika.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
