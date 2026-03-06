@extends('layouts.cms')

@section('title', 'Profil Alumni - ' . $alumni->alumni_name)
@section('page-title', 'Profil Alumni')
@section('header-title', $alumni->alumni_name)
@section('header-subtitle', 'Butiran alumni berdaftar')

@section('header-buttons')
<a href="{{ route('tadika.alumni') }}" class="btn btn-outline-secondary">
    <i class="fas fa-arrow-left me-2"></i> Kembali ke Senarai Alumni
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body text-center">
                @if($alumni->alumni_photo)
                <img src="{{ $alumni->alumni_photo_url }}"
                    alt="Profile Photo"
                    class="rounded-circle mb-3"
                    style="width: 100px; height: 100px; object-fit: cover;">
                @else
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 100px; height: 100px;">
                    <i class="fas fa-user-graduate fa-3x text-primary"></i>
                </div>
                @endif
                <h5 class="mb-1">{{ $alumni->alumni_name }}</h5>
                <p class="text-muted mb-2">{{ $alumni->job_position ?? 'Alumni' }}</p>
                <span class="badge bg-primary">Graduan {{ $alumni->grad_year }}</span>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-camera-retro me-2"></i>Then & Now</h6>
            </div>
            <div class="card-body">
                <div class="row text-center g-3">
                    <div class="col-6">
                        <p class="fw-bold mb-1">Childhood</p>
                        @if($alumni->photo_childhood)
                        <img src="{{ $alumni->photo_childhood_url }}" alt="Childhood Photo" class="img-fluid rounded">
                        @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 140px;">
                            <i class="fas fa-image fa-2x text-muted"></i>
                        </div>
                        @endif
                    </div>
                    <div class="col-6">
                        <p class="fw-bold mb-1">Current</p>
                        @if($alumni->photo_current)
                        <img src="{{ $alumni->photo_current_url }}" alt="Current Photo" class="img-fluid rounded">
                        @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 140px;">
                            <i class="fas fa-image fa-2x text-muted"></i>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Maklumat Alumni</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Email:</strong><br>{{ $alumni->user->user_email ?? $alumni->alumni_email ?? 'N/A' }}</p>
                        <p><strong>No. Telefon:</strong><br>{{ $alumni->alumni_phone ?? 'N/A' }}</p>
                        <p><strong>No. IC:</strong><br>{{ $alumni->alumni_ic ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status Semasa:</strong><br>
                            @if($alumni->alumni_status === 'studying')
                            <span class="badge bg-info"><i class="fas fa-graduation-cap me-1"></i> Sedang belajar</span>
                            @elseif($alumni->alumni_status === 'working')
                            <span class="badge bg-success"><i class="fas fa-briefcase me-1"></i> Bekerja</span>
                            @else
                            Tidak ditetapkan
                            @endif
                        </p>

                        @if($alumni->alumni_status === 'studying')
                        <p><strong>Institusi:</strong><br>{{ $alumni->institution ?? 'N/A' }}</p>
                        @elseif($alumni->alumni_status === 'working')
                        <p><strong>Syarikat:</strong><br>{{ $alumni->company ?? 'N/A' }}</p>
                        <p><strong>Jawatan:</strong><br>{{ $alumni->job_position ?? 'N/A' }}</p>
                        @endif
                    </div>
                </div>

                <hr>

                <p><strong>Alamat:</strong><br>{{ $alumni->alumni_address ?? 'N/A' }}</p>
                <p><strong>Ayah:</strong> {{ $alumni->father_name ?? 'N/A' }}</p>
                <p><strong>Ibu:</strong> {{ $alumni->mother_name ?? 'N/A' }}</p>
                <p><strong>Telefon Penjaga:</strong> {{ $alumni->parent_phone ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
