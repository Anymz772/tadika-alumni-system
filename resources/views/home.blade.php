@extends('layouts.public')

@section('title', 'Laman Utama - Sistem Alumni Tadika')
@section('content')
<div class="row align-items-center mb-5">
    <div class="col-md-6">
        <h1 class="display-4 fw-bold mb-4">Selamat datang ke Rangkaian Alumni</h1>
        <p class="lead mb-4">
            Sambungkan semula dengan rakan sekelas anda, kekal dikemas kini dengan berita sekolah,
            dan jadilah sebahagian daripada komuniti alumni kami yang berkembang. Perjalanan anda berterusan di sini.
        </p>
        <div class="d-flex gap-3">
            <a href="{{ route('alumni.register') }}" class="btn btn-tadika-primary btn-lg">
                <i class="fas fa-user-plus me-2"></i> Sertai sebagai Alumni
            </a>
            <a href="{{ route('tadika.register') }}" class="btn btn-outline-success btn-lg">
                <i class="fas fa-school me-2"></i> Daftar Tadika
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-sign-in-alt me-2"></i> Log Masuk Ahli
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
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Rangkaian Alumni</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="display-4 fw-bold text-primary">
                            {{ \App\Models\Alumni::count() }}
                        </div>
                        <p class="text-muted">Alumni Berdaftar</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="display-4 fw-bold text-success">
                            {{ \App\Models\Alumni::whereYear('grad_year', '>=', date('Y') - 5)->count() }}
                        </div>
                        <p class="text-muted">Graduan Terkini (5 tahun)</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="display-4 fw-bold text-info">
                            {{ \App\Models\Alumni::distinct('grad_year')->count('grad_year') }}
                        </div>
                        <p class="text-muted">Kumpulan Graduasi</p>
                    </div>
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
                        <h5>Menyumbang kepada Sekolah</h5>
                        <p class="text-muted">
                            Sertai acara sekolah, bimbing pelajar semasa, dan sumbang kepada pembangunan sekolah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
