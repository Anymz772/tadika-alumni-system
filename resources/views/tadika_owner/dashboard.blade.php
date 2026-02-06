@extends('layouts.cms')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">Tadika Dashboard</h2>
            <p class="text-muted mb-0">
                Welcome, {{ auth()->user()->name }}.
            </p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('tadika.edit') }}" class="btn btn-tadika-primary">
                Edit Tadika Profile
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted">Total Alumni</div>
                    <div class="display-6 fw-bold">{{ $alumniCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-2">Tadika Profile</h5>
                    @if($tadika)
                        <div><strong>Name:</strong> {{ $tadika->name }}</div>
                        <div><strong>Registration No:</strong> {{ $tadika->registration_number }}</div>
                        <div><strong>District:</strong> {{ $tadika->district }}</div>
                        <div><strong>State:</strong> {{ $tadika->state }}</div>
                    @else
                        <p class="text-muted mb-0">No Tadika profile found yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
