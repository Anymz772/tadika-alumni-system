@extends('layouts.cms')

@section('title', 'Profil Alumni Saya')
@section('page-title', 'Profil Saya')
@section('header-title', 'Profil Alumni Saya')
@section('header-subtitle', 'Lihat dan urus maklumat alumni anda')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                @if($alumni->alumni_photo)
                <img src="{{ asset('storage/' . $alumni->alumni_photo) }}"
                    alt="Profile Photo"
                    class="rounded-circle mb-3"
                    style="width: 100px; height: 100px; object-fit: cover;">
                @else
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 100px; height: 100px;">
                    <i class="fas fa-user-graduate fa-3x text-primary"></i>
                </div>
                @endif
                <h4>{{ $alumni->alumni_name }}</h4>
                <p class="text-muted">{{ $alumni->job_position ?? 'Alumni' }}</p>
                <div class="mt-2">
                    <span class="badge bg-primary">Graduan {{ $alumni->grad_year }}</span>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-users me-2"></i>Ibu Bapa</h6>
            </div>
            <div class="card-body">
                <p><strong>Father:</strong> {{ $alumni->father_name }}</p>
                <p><strong>Mother:</strong> {{ $alumni->mother_name }}</p>
                <p><strong>Contact:</strong> {{ $alumni->parent_phone }}</p>
            </div>
        </div>

        {{-- then & now photos --}}
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-camera-retro me-2"></i>Gambar Dulu & Sekarang</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <p class="fw-bold mb-1">Kanak-kanak</p>
                        @if($alumni->photo_childhood)
                            <img src="{{ asset('storage/' . $alumni->photo_childhood) }}" alt="Childhood Photo" class="img-fluid rounded">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-6">
                        <p class="fw-bold mb-1">Sekarang</p>
                        @if($alumni->photo_current)
                            <img src="{{ asset('storage/' . $alumni->photo_current) }}" alt="Current Photo" class="img-fluid rounded">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Butiran Profil</h6>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>E-mel:</strong><br>{{ $alumni->alumni_email }}</p>
                        <p><strong>Nombor Kenalan:</strong><br>{{ $alumni->alumni_phone }}</p>
                        <p><strong>No. IC:</strong><br>{{ $alumni->alumni_ic ?? 'N/A' }}</p>
                        <p><strong>Umur:</strong><br>{{ $alumni->age ?? 'N/A' }}</p>
                        <p><strong>Jantina:</strong><br>{{ ucfirst($alumni->gender) ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Current Status:</strong><br>
                            @if($alumni->alumni_status === 'studying')
                            <span class="badge bg-info"><i class="fas fa-graduation-cap me-1"></i> Sedang belajar</span>
                            @elseif($alumni->alumni_status === 'working')
                            <span class="badge bg-success"><i class="fas fa-briefcase me-1"></i> Bekerja</span>
                            @else
                            N/A
                            @endif
                        </p>
                        @if($alumni->alumni_status === 'studying')
                        <p><strong>Institusi:</strong><br>{{ $alumni->institution ?? 'N/A' }}</p>
                        @elseif($alumni->alumni_status === 'working')
                        <p><strong>Syarikat:</strong><br>{{ $alumni->company ?? 'N/A' }}</p>
                        <p><strong>Jawatan:</strong><br>{{ $alumni->job_position ?? 'N/A' }}</p>
                        @endif
                        <p><strong>Nama Tadika:</strong><br>{{ $alumni->tadika_name ?? 'N/A' }}</p>
                        <p><strong>Negeri:</strong><br>{{ $alumni->alumni_state ?? 'N/A' }}</p>
                        <p><strong>Alamat:</strong><br>{{ $alumni->alumni_address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            @if($alumni->created_at)
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-calendar-plus me-1"></i>
                            Profile Created: {{ $alumni->created_at->format('d M Y, H:i') }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="fas fa-calendar-check me-1"></i>
                            Last Updated: {{ $alumni->updated_at->format('d M Y, H:i') }}
                        </small>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Tindakan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning w-100">
                            <i class="fas fa-edit me-2"></i> Sunting Profil
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary w-100">
                            <i class="fas fa-home me-2"></i> Papan Pemuka
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-envelope me-2"></i>Mesej Dari Tadika</h6>
                <small class="text-muted">20 Terakhir</small>
            </div>
            <div class="card-body">
                @if(isset($messages) && $messages->count())
                    @foreach($messages as $item)
                        <div class="border rounded p-3 mb-3 {{ is_null($item->read_at) ? 'bg-light' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $item->data['subject'] ?? 'No Subject' }}</h6>
                                    <small class="text-muted">
                                        From: {{ $item->data['sender_name'] ?? 'Tadika Owner' }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block mb-2">{{ $item->created_at?->format('d M Y, H:i') }}</small>
                                    <form action="{{ route('notifications.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Padam mesej ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash me-1"></i>Padam
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="mb-0 mt-2">{{ $item->data['message'] ?? '' }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">Tiada mesej dalam aplikasi lagi.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
