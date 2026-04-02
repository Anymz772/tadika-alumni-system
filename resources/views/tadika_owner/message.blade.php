@extends('layouts.cms')

@section('title', isset($alumni) ? 'Mesej kepada ' . $alumni->alumni_name : 'Mesej kepada Semua Alumni')
@section('page-title', 'Hantar Mesej')
@section('header-title', isset($alumni) ? 'Mesej kepada ' . $alumni->alumni_name : 'Siaran Mesej kepada Semua Alumni')
@section('header-subtitle', 'Hantar pemberitahuan dalam aplikasi kepada alumni')

@section('header-buttons')
    <a href="{{ route('tadika.alumni') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali ke Senarai Alumni
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-envelope me-2"></i>
                    {{ isset($alumni) ? 'Mesej Peribadi' : 'Siaran kepada Semua Alumni (' . ($totalAlumniCount ?? 0) . ' penerima)' }}
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" {{ isset($alumni) ? 'action=' . route('tadika.alumni.message', $alumni) : 'action=' . route('tadika.alumni.message_all') }}>
                    @csrf
                    
                    <div class="mb-4">
                        @if(isset($alumni))
                            <div class="alert alert-info">
                                <strong>Penerima:</strong> {{ $alumni->alumni_name }} 
                                <br><small class="text-muted">{{ $alumni->user->user_email ?? $alumni->alumni_email }}</small>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <strong>Penerima:</strong> Semua {{ $totalAlumniCount ?? 0 }} alumni yang mempunyai akaun log masuk
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Subjek <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                               id="subject" name="subject" 
                               value="{{ old('subject') }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="message" class="form-label">Mesej <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  id="message" name="message" rows="8" 
                                  placeholder="Tulis mesej anda di sini... (akan dihantar sebagai pemberitahuan dalam aplikasi)" 
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tadika.alumni') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>
                            {{ isset($alumni) ? 'Hantar Mesej' : 'Siar Mesej' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection