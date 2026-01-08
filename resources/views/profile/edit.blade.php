@extends('layouts.app')

@if ($errors->any())
<div class="alert alert-danger shadow-sm">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
<div class="alert alert-success shadow-sm">
    {{ session('success') }}
</div>
@endif

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-user-edit me-2"></i>Edit My Profile
                        </h4>
                        <div>
                            <a href="{{ route('profile.show') }}" class="btn btn-dark btn-sm">
                                <i class="fas fa-eye me-1"></i> View Profile
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3 text-primary">Personal Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="full_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                    id="full_name" name="full_name"
                                    value="{{ old('full_name', $alumni->full_name) }}" required>
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="ic_number" class="form-label">IC Number</label>
                                <input type="text" class="form-control @error('ic_number') is-invalid @enderror"
                                    id="ic_number" name="ic_number"
                                    value="{{ old('ic_number', $alumni->ic_number) }}">
                                @error('ic_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="year_graduated" class="form-label">Year Graduated *</label>
                                <input type="number" class="form-control @error('year_graduated') is-invalid @enderror"
                                    id="year_graduated" name="year_graduated"
                                    min="2000" max="{{ date('Y') }}"
                                    value="{{ old('year_graduated', $alumni->year_graduated) }}" required>
                                @error('year_graduated')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contact_number" class="form-label">Contact Number *</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror"
                                    id="contact_number" name="contact_number"
                                    value="{{ old('contact_number', $alumni->contact_number) }}" required>
                                @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Profile Photo</label>
                            @if($alumni->photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $alumni->photo) }}" alt="Current Photo" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                id="photo" name="photo" accept="image/*">
                            <div class="form-text">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                            @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="mb-3 text-primary mt-4">Professional Information</h5>

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

                        <!-- Conditional Fields for Studying -->
                        <div id="studying-fields" class="conditional-fields" style="display: none;">
                            <div class="mb-3">
                                <label for="institution_name" class="form-label">Institution Name *</label>
                                <input type="text" class="form-control"
                                    id="institution_name" name="institution_name" value="{{ old('institution_name', $alumni->institution_name) }}">
                            </div>
                        </div>

                        <!-- Conditional Fields for Working -->
                        <div id="working-fields" class="conditional-fields" style="display: none;">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="company_name" class="form-label">Company Name *</label>
                                    <input type="text" class="form-control"
                                        id="company_name" name="company_name" value="{{ old('company_name', $alumni->company_name) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="job_position" class="form-label">Job Title *</label>
                                    <input type="text" class="form-control"
                                        id="job_position" name="job_position" value="{{ old('job_position', $alumni->job_position) }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address"
                                rows="3">{{ old('address', $alumni->address) }}</textarea>
                        </div>

                        <h5 class="mb-3 text-primary mt-4">Parents Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="father_name" class="form-label">Father's Name</label>
                                <input type="text" class="form-control @error('father_name') is-invalid @enderror"
                                    id="father_name" name="father_name"
                                    value="{{ old('father_name', $alumni->father_name) }}">
                                @error('father_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="mother_name" class="form-label">Mother's Name</label>
                                <input type="text" class="form-control @error('mother_name') is-invalid @enderror"
                                    id="mother_name" name="mother_name"
                                    value="{{ old('mother_name', $alumni->mother_name) }}">
                                @error('mother_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="parent_contact" class="form-label">Parent Contact Number</label>
                            <input type="text" class="form-control @error('parent_contact') is-invalid @enderror"
                                id="parent_contact" name="parent_contact"
                                value="{{ old('parent_contact', $alumni->parent_contact) }}">
                            @error('parent_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card mb-4 shadow-sm border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h5>Change Password</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">Leave these fields blank if you do not wish to change your password.</p>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>New Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Confirm New Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Re-type password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

        // Initial check on page load (for form validation errors)
        toggleFields();

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