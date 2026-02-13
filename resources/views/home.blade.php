@extends('layouts.public')

@section('title', 'Home - Tadika Alumni System')
@section('content')
<div class="row align-items-center mb-5">
    <div class="col-md-6">
        <h1 class="display-4 fw-bold mb-4">Welcome to Alumni Network</h1>
        <p class="lead mb-4">
            Reconnect with your classmates, stay updated with school news, 
            and be part of our growing alumni community. Your journey continues here.
        </p>
        <div class="d-flex gap-3">
            <a href="{{ route('alumni.register') }}" class="btn btn-tadika-primary btn-lg">
                <i class="fas fa-user-plus me-2"></i> Join as Alumni
            </a>
            <a href="{{ route('tadika.register') }}" class="btn btn-outline-success btn-lg">
                <i class="fas fa-school me-2"></i> Register Tadika
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-sign-in-alt me-2"></i> Member Login
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0">
            <div class="card-body text-center p-5">
                <i class="fas fa-graduation-cap fa-6x text-primary mb-4"></i>
                <h3 class="mb-3">Official Alumni Portal</h3>
                <p class="text-muted">
                    Exclusive platform for Tadika graduates to network, 
                    share opportunities, and participate in alumni events.
                </p>
            </div>
        </div>
    </div>
</div>


<!-- Statistics -->
<div class="row mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Alumni Network Statistics</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="display-4 fw-bold text-primary">
                            {{ \App\Models\Alumni::count() }}
                        </div>
                        <p class="text-muted">Registered Alumni</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="display-4 fw-bold text-success">
                            {{ \App\Models\Alumni::whereYear('year_graduated', '>=', date('Y') - 5)->count() }}
                        </div>
                        <p class="text-muted">Recent Graduates (5 years)</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="display-4 fw-bold text-info">
                            {{ \App\Models\Alumni::distinct('year_graduated')->count('year_graduated') }}
                        </div>
                        <p class="text-muted">Graduation Batches</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features -->
<div class="row">
    <div class="col-md-12">
        <h3 class="mb-4 text-center">Why Join as Alumni?</h3>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-network-wired fa-3x text-primary"></i>
                        </div>
                        <h5>Networking Opportunities</h5>
                        <p class="text-muted">
                            Connect with alumni across different industries and build professional relationships.
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
                        <h5>Career Development</h5>
                        <p class="text-muted">
                            Access job opportunities, mentorship programs, and career guidance from senior alumni.
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
                        <h5>Give Back to School</h5>
                        <p class="text-muted">
                            Participate in school events, mentor current students, and contribute to school development.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
