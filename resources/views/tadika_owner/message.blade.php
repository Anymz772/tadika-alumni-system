@extends('layouts.cms')

@section('title', 'Hantar Mesej')
@section('page-title', isset($alumni) ? 'Mesej ' . $alumni->alumni_name : 'Mesej Alumni')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="mb-1">
                    @if(isset($alumni))
                        Hantar mesej kepada {{ $alumni->alumni_name }}
                    @else
                        Hantar mesej kepada <strong>semua alumni</strong>
                    @endif
                </h2>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('tadika.alumni') }}" class="btn btn-outline-secondary">
                    Kembali ke Senarai
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="alert alert-info">
                    Mesej ini akan dihantar ke peti masuk dalam aplikasi, bukan melalui e-mel.
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ isset($alumni) ? route('tadika.alumni.message', $alumni->alumni_id) : route('tadika.alumni.message_all') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Subjek</label>
                        <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mesej</label>
                        <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Hantar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
