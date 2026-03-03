@extends('layouts.public')

@section('title', 'Pendaftaran Berjaya - Sistem Alumni Tadika')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card text-center">
            <div class="card-body p-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle fa-4x text-success"></i>
                </div>
                <h2 class="mb-3">Pendaftaran Berjaya</h2>
                <p class="text-muted mb-4">
                    Akaun Tadika anda telah dibuat. Anda kini boleh log masuk dan lengkapkan profil Tadika anda.
                </p>
                <a href="{{ route('login') }}" class="btn btn-tadika-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i> Pergi ke Log Masuk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
