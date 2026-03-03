@extends('layouts.cms')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">Senarai Alumni</h2>
            <p class="text-muted mb-0">
                Tadika: {{ $tadika->tadika_name }}
            </p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('tadika.dashboard') }}" class="btn btn-outline-secondary">
                Kembali ke Papan Pemuka
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($alumni->count() === 0)
                <p class="text-muted mb-0">Tiada alumni ditemui untuk Tadika ini.</p>
            @else
                <div class="mb-3 text-end">
                    <a href="{{ route('tadika.alumni.message_all.form') }}" class="btn btn-outline-primary">
                        <i class="fas fa-envelope"></i> Hantar mesej kepada semua alumni
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tahun Graduasi</th>
                                <th>Kenalan</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumni as $item)
                                <tr>
                                    <td>{{ $item->alumni_name }}</td>
                                    <td>{{ $item->alumni_email }}</td>
                                    <td>{{ $item->grad_year ?? '-' }}</td>
                                    <td>{{ $item->alumni_phone ?? '-' }}</td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('tadika.alumni.edit', $item->alumni_id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Sunting
                                        </a>
                                        <a href="{{ route('tadika.alumni.message.form', $item->alumni_id) }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-envelope"></i> Mesej
                                        </a>
                                    </td>
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