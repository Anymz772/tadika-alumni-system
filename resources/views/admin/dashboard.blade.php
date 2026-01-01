@extends('layouts.cms')

@section('title', 'Dashboard - Tadika Alumni CMS')
@section('page-title', 'Dashboard')
@section('header-title', 'CMS Dashboard')
@section('header-subtitle', 'Welcome back, ' . Auth::user()->name)

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x"></i>
                <div class="count mt-2">{{ $stats['total_alumni'] }}</div>
                <div class="label">Total Alumni</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-user-check fa-2x"></i>
                <div class="count mt-2">{{ $stats['total_users'] }}</div>
                <div class="label">Total Users</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-calendar-alt fa-2x"></i>
                <div class="count mt-2">{{ $stats['recent_alumni'] }}</div>
                <div class="label">New This Year</div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-2x"></i>
                <div class="count mt-2">{{ $stats['alumni_by_year']->count() }}</div>
                <div class="label">Graduation Years</div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Alumni</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Graduation Year</th>
                                <th>Workplace</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentAlumni as $alumni)
                            <tr>
                                <td><strong>{{ $alumni->full_name }}</strong><br><small>{{ $alumni->email }}</small></td>
                                <td>{{ $alumni->year_graduated }}</td>
                                <td>{{ $alumni->current_workplace ?? 'N/A' }}</td>
                                <td>
                                    <!-- FIXED: Using correct route names -->
                                    <a href="{{ route('alumni.show', $alumni->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('alumni.edit', $alumni->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Graduation Years</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($stats['alumni_by_year'] as $year)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $year->year_graduated }}
                        <span class="badge bg-primary">{{ $year->count }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <!-- FIXED: Using correct route names -->
                <a href="{{ route('alumni.create') }}" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-user-plus me-2"></i> Add New Alumni
                </a>
                <a href="{{ route('alumni.index') }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-list me-2"></i> View All Alumni
                </a>
            </div>
        </div>
    </div>
</div>
@endsection