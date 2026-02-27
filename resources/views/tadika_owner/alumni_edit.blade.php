@extends('layouts.cms')

@section('title', 'Edit Alumni - ' . $alumni->alumni_name)
@section('page-title', 'Edit Alumni')
@section('header-title', 'Edit: ' . $alumni->alumni_name)

@section('header-buttons')
    <a href="{{ route('tadika.alumni.message.form', $alumni->alumni_id) }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-envelope me-2"></i> Message
    </a>
    <a href="{{ route('tadika.alumni') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Back to list
    </a>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-primary"><i class="fas fa-user-edit me-2"></i>Update Alumni Details</h5>
        </div>

        <form method="POST" action="{{ route('tadika.alumni.update', $alumni->alumni_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- reuse the same form fields as general alumni.edit --}}
                @include('alumni.partials.form-fields', ['alumni' => $alumni])

            </div>

            <div class="card-footer bg-light d-flex justify-content-end gap-2 p-3">
                <a href="{{ route('tadika.alumni') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i> Update Alumni
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
