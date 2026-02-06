@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">Alumni List</h2>
            <p class="text-muted mb-0">
                Tadika: {{ $tadika->name }}
            </p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('tadika.dashboard') }}" class="btn btn-outline-secondary">
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($alumni->count() === 0)
                <p class="text-muted mb-0">No alumni found for this Tadika.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Year Graduated</th>
                                <th>Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumni as $item)
                                <tr>
                                    <td>{{ $item->full_name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->year_graduated ?? '-' }}</td>
                                    <td>{{ $item->contact_number ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $alumni->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
