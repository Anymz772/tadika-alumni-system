@extends('layouts.cms')

@section('title', 'Kemaskini Alumni - ' . $alumni->alumni_name)
@section('page-title', 'Kemaskini Alumni')
@section('header-title', 'Kemaskini: ' . $alumni->alumni_name)

@section('header-buttons')
    <a href="{{ route('tadika.alumni.message.form', $alumni->alumni_id) }}" class="btn btn-sm btn-outline-secondary me-1">
        <i class="fas fa-envelope me-1"></i> Mesej
    </a>
    <a href="{{ route('tadika.alumni') }}" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke senarai
    </a>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-2">
            <h6 class="mb-0 text-primary"><i class="fas fa-user-edit me-2"></i>Kemaskini Butiran Alumni</h6>
        </div>

        <form method="POST" action="{{ route('tadika.alumni.update', $alumni->alumni_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body px-4 py-4">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show small" role="alert">
                        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @include('alumni.partials.form-fields', ['alumni' => $alumni])

            </div>

            <div class="card-footer bg-white py-3 d-flex justify-content-end gap-2">
                <a href="{{ route('tadika.alumni') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-sm btn-primary px-4">
                    <i class="fas fa-save me-1"></i> Kemaskini Alumni
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const studyingRadio = document.getElementById('studying');
            const workingRadio = document.getElementById('working');
            const studyingFields = document.getElementById('studying-fields');
            const workingFields = document.getElementById('working-fields');

            function toggleFields() {
                if (!studyingRadio || !workingRadio) return;

                if (studyingRadio.checked) {
                    studyingFields.style.display = 'block';
                    workingFields.style.display = 'none';
                } else if (workingRadio.checked) {
                    workingFields.style.display = 'block';
                    studyingFields.style.display = 'none';
                } else {
                    studyingFields.style.display = 'none';
                    workingFields.style.display = 'none';
                }
            }

            toggleFields();

            if (studyingRadio) studyingRadio.addEventListener('change', toggleFields);
            if (workingRadio) workingRadio.addEventListener('change', toggleFields);
        });
    </script>
@endpush