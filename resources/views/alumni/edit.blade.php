@extends('layouts.cms')

@section('title', 'Edit Alumni - ' . $alumni->full_name)
@section('page-title', 'Edit Alumni')
@section('header-title', 'Edit: ' . $alumni->full_name)

@section('header-buttons')
<a href="{{ route('alumni.show', $alumni->id) }}" class="btn btn-info me-2">
    <i class="fas fa-eye me-2"></i> View
</a>
<a href="{{ route('alumni.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i> Back
</a>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Alumni</h5>
    </div>

    <form method="POST" action="{{ route('alumni.update', $alumni->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control" name="full_name"
                            value="{{ old('full_name', $alumni->full_name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email', $alumni->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Number *</label>
                        <input type="text" class="form-control" name="contact_number"
                            value="{{ old('contact_number', $alumni->contact_number) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Year Graduated *</label>
                        <input type="number" class="form-control" name="year_graduated"
                            value="{{ old('year_graduated', $alumni->year_graduated) }}" min="2000" max="{{ date('Y') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">IC Number *</label>
                        <input type="text" class="form-control" name="ic_number"
                            value="{{ old('ic_number', $alumni->ic_number) }}" required>
                    </div>

                    <!-- Current Status Selection -->
                    <div class="mb-4">
                        <label class="form-label">Current Status *</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="current_status" id="studying" value="studying"
                                        {{ old('current_status', $alumni->current_status) === 'studying' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="studying">
                                        <i class="fas fa-graduation-cap me-2"></i>Studying
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="current_status" id="working" value="working"
                                        {{ old('current_status', $alumni->current_status) === 'working' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="working">
                                        <i class="fas fa-briefcase me-2"></i>Working
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Institution and Employment Fields (Conditional for admin) -->
                    <div id="studying-fields" class="conditional-fields" style="display: none;">
                        <div class="mb-3">
                            <label for="institution_name" class="form-label">Institution Name</label>
                            <input type="text" class="form-control"
                                id="institution_name" name="institution_name" value="{{ old('institution_name', $alumni->institution_name) }}">
                        </div>
                    </div>

                    <div id="working-fields" class="conditional-fields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" class="form-control"
                                    id="company_name" name="company_name" value="{{ old('company_name', $alumni->company_name) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="job_position" class="form-label">Job Title</label>
                                <input type="text" class="form-control"
                                    id="job_position" name="job_position" value="{{ old('job_position', $alumni->job_position) }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profile Photo</label>
                        @if($alumni->photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $alumni->photo) }}" alt="Current Photo" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                        @endif
                        <input type="file" class="form-control" name="photo" accept="image/*">
                        <div class="form-text">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address *</label>
                        <textarea class="form-control" name="address" rows="2" required>{{ old('address', $alumni->address) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Father's Name</label>
                        <input type="text" class="form-control" name="father_name"
                            value="{{ old('father_name', $alumni->father_name) }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Mother's Name</label>
                        <input type="text" class="form-control" name="mother_name"
                            value="{{ old('mother_name', $alumni->mother_name) }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Parent Contact</label>
                <input type="text" class="form-control" name="parent_contact"
                    value="{{ old('parent_contact', $alumni->parent_contact) }}">
            </div>
        </div>

        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <a href="{{ route('alumni.show', $alumni->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Update
                </button>
            </div>
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
            if (studyingRadio && studyingRadio.checked) {
                studyingFields.style.display = 'block';
                workingFields.style.display = 'none';
            } else if (workingRadio && workingRadio.checked) {
                workingFields.style.display = 'block';
                studyingFields.style.display = 'none';
            } else {
                studyingFields.style.display = 'none';
                workingFields.style.display = 'none';
            }
        }

        // Initial check on page load (for form validation errors and existing data)
        toggleFields();

        // Show fields based on existing alumni data if no radio is selected
        if (!studyingRadio.checked && !workingRadio.checked) {
            const currentStatus = '{{ $alumni->current_status }}';
            if (currentStatus === 'studying') {
                studyingRadio.checked = true;
                studyingFields.style.display = 'block';
            } else if (currentStatus === 'working') {
                workingRadio.checked = true;
                workingFields.style.display = 'block';
            }
        }

        // Add event listeners if elements exist
        if (studyingRadio) {
            studyingRadio.addEventListener('change', toggleFields);
        }
        if (workingRadio) {
            workingRadio.addEventListener('change', toggleFields);
        }

        // Force show fields if there are validation errors for conditional fields
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('errors') || document.querySelector('.is-invalid')) {
            // Check if we have old input values
            const currentStatus = document.querySelector('input[name="current_status"]:checked');
            if (!currentStatus) {
                // If no radio is checked but we have validation errors, check the appropriate radio based on old input
                const oldInstitution = document.getElementById('institution_name').value;
                const oldCompany = document.getElementById('company_name').value;

                if (oldInstitution) {
                    studyingRadio.checked = true;
                    toggleFields();
                } else if (oldCompany) {
                    workingRadio.checked = true;
                    toggleFields();
                }
            }
        }
    });
</script>
@endpush