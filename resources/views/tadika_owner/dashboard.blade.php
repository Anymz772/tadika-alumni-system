@extends('layouts.cms')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">Tadika Dashboard</h2>
            <p class="text-muted mb-0">
                Welcome, {{ auth()->user()->user_name }}.
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
                        <div><strong>Name:</strong> {{ $tadika->tadika_name }}</div>
                        <div><strong>Registration No:</strong> {{ $tadika->tadika_reg_no }}</div>
                        <div><strong>District:</strong> {{ $tadika->tadika_district }}</div>
                        <div><strong>State:</strong> {{ $tadika->tadika_state }}</div>
                        <div><strong>Postcode:</strong> {{ $tadika->tadika_postcode }}</div>
                    @else
                        <p class="text-muted mb-0">No Tadika profile found yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
