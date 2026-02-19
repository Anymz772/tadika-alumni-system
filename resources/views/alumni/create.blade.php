@extends('layouts.cms')

@section('title', 'Add New Alumni')
@section('page-title', 'Add Alumni')
@section('header-title', 'Add New Alumni')

@section('header-buttons')
    <a href="{{ route('alumni.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Back
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Add New Alumni</h5>
    </div>

    <form method="POST" action="{{ route('alumni.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <h6 class="fw-bold mb-3 text-primary">Personal Information</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name *</label>
                    <input type="text" class="form-control @error('alumni_name') is-invalid @enderror" 
                           name="alumni_name" value="{{ old('alumni_name') }}" required>
                    @error('alumni_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Login Username *</label>
                    <input type="text" class="form-control @error('user_name') is-invalid @enderror" 
                           name="user_name" value="{{ old('user_name') }}" required>
                    @error('user_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email Address *</label>
                    <input type="email" class="form-control @error('user_email') is-invalid @enderror" 
                           name="user_email" value="{{ old('user_email') }}" required>
                    @error('user_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Number *</label>
                    <input type="text" class="form-control @error('alumni_phone') is-invalid @enderror" 
                           name="alumni_phone" value="{{ old('alumni_phone') }}" required>
                    @error('alumni_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">IC Number *</label>
                    <input type="text" class="form-control @error('alumni_ic') is-invalid @enderror" 
                           name="alumni_ic" value="{{ old('alumni_ic') }}" required>
                    @error('alumni_ic')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                        <option value="">-- Select Gender --</option>
                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control @error('age') is-invalid @enderror" 
                           name="age" min="1" max="100" value="{{ old('age') }}">
                    @error('age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>
            <h6 class="fw-bold mb-3 text-primary">Academic & Background</h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Year Graduated *</label>
                    <input type="number" class="form-control @error('grad_year') is-invalid @enderror" 
                           name="grad_year" min="2000" max="{{ date('Y') }}" value="{{ old('grad_year') }}" required>
                    @error('grad_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tadika Name</label>
                    <input type="text" class="form-control @error('tadika_name') is-invalid @enderror" 
                           name="tadika_name" value="{{ old('tadika_name') }}">
                    @error('tadika_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">State</label>
                    <input type="text" class="form-control @error('alumni_state') is-invalid @enderror" 
                           name="alumni_state" value="{{ old('alumni_state') }}">
                    @error('alumni_state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address *</label>
                <textarea class="form-control @error('alumni_address') is-invalid @enderror" name="alumni_address" rows="2" required>{{ old('alumni_address') }}</textarea>
                @error('alumni_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>
            <h6 class="fw-bold mb-3 text-primary">Current Status</h6>
            <div class="mb-4">
                <div class="d-flex gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="alumni_status" id="studying" 
                               value="studying" {{ old('alumni_status') === 'studying' ? 'checked' : '' }}>
                        <label class="form-check-label" for="studying">
                            <i class="fas fa-graduation-cap me-1"></i> Studying
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="alumni_status" id="working" 
                               value="working" {{ old('alumni_status') === 'working' ? 'checked' : '' }}>
                        <label class="form-check-label" for="working">
                            <i class="fas fa-briefcase me-1"></i> Working
                        </label>
                    </div>
                </div>
                @error('alumni_status')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div id="studying-fields" class="mb-3" style="display: none;">
                <label for="institution" class="form-label fw-bold">Institution Name</label>
                <input type="text" class="form-control @error('institution') is-invalid @enderror" 
                       id="institution" name="institution" value="{{ old('institution') }}">
                @error('institution')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="working-fields" style="display: none;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="company" class="form-label fw-bold">Company Name</label>
                        <input type="text" class="form-control @error('company') is-invalid @enderror" 
                               id="company" name="company" value="{{ old('company') }}">
                        @error('company')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="job_position" class="form-label fw-bold">Job Title</label>
                        <input type="text" class="form-control @error('job_position') is-invalid @enderror" 
                               id="job_position" name="job_position" value="{{ old('job_position') }}">
                        @error('job_position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>
            <h6 class="fw-bold mb-3 text-primary">Family Information</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Father's Name</label>
                    <input type="text" class="form-control @error('father_name') is-invalid @enderror" 
                           name="father_name" value="{{ old('father_name') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mother's Name</label>
                    <input type="text" class="form-control @error('mother_name') is-invalid @enderror" 
                           name="mother_name" value="{{ old('mother_name') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Parent Contact</label>
                    <input type="text" class="form-control @error('parent_phone') is-invalid @enderror" 
                           name="parent_phone" value="{{ old('parent_phone') }}">
                </div>
            </div>

            <hr>
            <h6 class="fw-bold mb-3 text-primary">Security & Media</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password *</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password *</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Photo</label>
                <input type="file" class="form-control @error('alumni_photo') is-invalid @enderror" name="alumni_photo" accept="image/*">
                <div class="form-text">Accepted formats: JPEG, PNG, JPG. Max size: 2MB</div>
                @error('alumni_photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-2"></i> Create Alumni
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

        studyingRadio.addEventListener('change', toggleFields);
        workingRadio.addEventListener('change', toggleFields);

        toggleFields();
    });
</script>
@endpush