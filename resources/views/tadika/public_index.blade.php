@extends('layouts.public')

@section('title', 'Daftar Tadika - Rangkaian Alumni Tadika')
@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Senarai Tadika Berdaftar</h2>
                </div>
                <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">
                    Kembali ke Laman Utama <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                </a>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('tadikas.public.index') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama tadika">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="district" list="district-list" value="{{ request('district') }}" class="form-control" placeholder="Cari daerah">
                        <datalist id="district-list">
                            @foreach($districts as $district)
                                <option value="{{ $district }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="state" name="state">
                            <option value="">-- Pilih Negeri --</option>
                            @foreach($states as $state)
                                <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Cari
                        </button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Tadika</th>
                                <th>Daerah</th>
                                <th>Negeri</th>
                                <th>Tahun Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tadikas as $item)
                                <tr>
                                    <td>{{ $item->tadika_name }}</td>
                                    <td>{{ $item->tadika_district }}</td>
                                    <td>{{ $item->tadika_state }}</td>
                                    <td>{{ optional($item->created_at)->year ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Tiada tadika ditemui untuk kriteria tersebut.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menunjukkan {{ $tadikas->total() }} tadika yang berdaftar.
                    </div>
                    <div>
                        {{ $tadikas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
