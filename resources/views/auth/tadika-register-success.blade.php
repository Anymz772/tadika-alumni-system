@extends('layouts.public')

@section('title', 'Registration Successful - Tadika Alumni System')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card text-center">
            <div class="card-body p-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle fa-4x text-success"></i>
                </div>
                <h2 class="mb-3">Registration Successful</h2>
                <p class="text-muted mb-4">
                    Your Tadika account has been created. You can now log in and complete your Tadika profile.
                </p>
                <a href="{{ route('login') }}" class="btn btn-tadika-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i> Go to Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
