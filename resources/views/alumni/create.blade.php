@extends('layouts.cms')

@section('title', 'Add New Alumni')
@section('page-title', 'Add Alumni')
@section('header-title', 'Add New Alumni')

@section('header-buttons')
<a href="{{ route('alumni.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i> Back
</a>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Conditional fields JavaScript loaded');

        const studyingRadio = document.getElementById('studying');
        const workingRadio = document.getElementById('working');
        const studyingFields = document.getElementById('studying-fields');
        const workingFields = document.getElementById('working-fields');

        console.log('Elements found:', {
            studyingRadio: !!studyingRadio,
            workingRadio: !!workingRadio,
            studyingFields: !!studyingFields,
            workingFields: !!workingFields
        });

        function toggleFields() {
            console.log('toggleFields called');
            console.log('studyingRadio.checked:', studyingRadio ? studyingRadio.checked : 'N/A');
            console.log('workingRadio.checked:', workingRadio ? workingRadio.checked : 'N/A');

            if (studyingRadio && studyingRadio.checked) {
                studyingFields.style.display = 'block';
                workingFields.style.display = 'none';
                console.log('Showing studying fields');
            } else if (workingRadio && workingRadio.checked) {
                workingFields.style.display = 'block';
                studyingFields.style.display = 'none';
                console.log('Showing working fields');
            } else {
                studyingFields.style.display = 'none';
                workingFields.style.display = 'none';
                console.log('Hiding all fields');
            }
        }

        // Initial check on page load (for form validation errors)
        toggleFields();

        // Add event listeners if elements exist
        if (studyingRadio) {
            studyingRadio.addEventListener('change', function() {
                console.log('Studying radio changed');
                toggleFields();
            });
        }
        if (workingRadio) {
            workingRadio.addEventListener('change', function() {
                console.log('Working radio changed');
                toggleFields();
            });
        }

        // Force show fields if there are validation errors for conditional fields
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('errors') || document.querySelector('.is-invalid')) {
            console.log('Validation errors detected');
            // Check if we have old input values
            const currentStatus = document.querySelector('input[name="current_status"]:checked');
            if (!currentStatus) {
                // If no radio is checked but we have validation errors, check the appropriate radio based on old input
                const oldInstitution = document.getElementById('institution_name').value;
                const oldCompany = document.getElementById('company_name').value;

                if (oldInstitution) {
                    console.log('Setting studying radio based on old input');
                    studyingRadio.checked = true;
                    toggleFields();
                } else if (oldCompany) {
                    console.log('Setting working radio based on old input');
                    workingRadio.checked = true;
                    toggleFields();
                }
            }
        }
    });
</script>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Add New Alumni</h5>
    </div>

    <form method="POST" action="{{ route('alumni.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" required>
                        @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Number *</label>
                        <input type="number" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" required>
                        @error('contact_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Year Graduated *</label>
                        <input type="number" class="form-control @error('year_graduated') is-invalid @enderror" name="year_graduated" min="1980" max="{{ date('Y') }}" required>
                        @error('year_graduated')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Login Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">IC Number *</label>
                        <input type="number" class="form-control @error('ic_number') is-invalid @enderror" name="ic_number" required>
                        @error('ic_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Photo</label>
                <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" accept="image/*">
                <div class="form-text">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Current Status Selection -->
            <div class="mb-4">
                <label class="form-label">Current Status *</label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="current_status" id="studying" value="studying"
                                {{ old('current_status') === 'studying' ? 'checked' : '' }}>
                            <label class="form-check-label" for="studying">
                                <i class="fas fa-graduation-cap me-2"></i>Studying
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="current_status" id="working" value="working"
                                {{ old('current_status') === 'working' ? 'checked' : '' }}>
                            <label class="form-check-label" for="working">
                                <i class="fas fa-briefcase me-2"></i>Working
                            </label>
                        </div>
                    </div>
                </div>
                @error('current_status')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Institution and Employment Fields (Conditional for admin) -->
            <div id="studying-fields" class="conditional-fields" style="display: none;">
                <div class="mb-3">
                    <label for="institution_name" class="form-label">Institution Name</label>
                    <input type="text" class="form-control @error('institution_name') is-invalid @enderror"
                        id="institution_name" name="institution_name" value="{{ old('institution_name') }}">
                    @error('institution_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div id="working-fields" class="conditional-fields" style="display: none;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                            id="company_name" name="company_name" value="{{ old('company_name') }}">
                        @error('company_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="job_position" class="form-label">Job Title</label>
                        <input type="text" class="form-control @error('job_position') is-invalid @enderror"
                            id="job_position" name="job_position" value="{{ old('job_position') }}">
                        @error('job_position')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address *</label>
                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="2" required></textarea>
                @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Father's Name</label>
                        <input type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name">
                        @error('father_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Mother's Name</label>
                        <input type="text" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name">
                        @error('mother_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Parent Contact</label>
                <input type="text" class="form-control @error('parent_contact') is-invalid @enderror" name="parent_contact">
                @error('parent_contact')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Create Alumni
            </button>
        </div>
    </form>
</div>
@endsection