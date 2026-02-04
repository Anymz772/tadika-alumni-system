@extends('layouts.cms')

@section('title', 'Edit My Profile')
@section('page-title', 'Edit Profile')
@section('header-title', 'Edit My Alumni Profile')
@section('header-subtitle', 'Update your personal and professional information')

@section('header-buttons')
    <a href="{{ route('profile.show') }}" class="btn btn-info">
        <i class="fas fa-eye me-2"></i> View Profile
    </a>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0 text-primary"><i class="fas fa-user-edit me-2"></i>Edit Profile</h5>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">
            {{-- Alert Messages --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> Please fix the errors below.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- SECTION 1: Personal Information --}}
            <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">Personal Information</h6>
            
            <div class="row">
                {{-- Full Name --}}
                <div class="col-md-6 mb-3">
                    <label for="full_name" class="form-label">Full Name *</label>
                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                           id="full_name" name="full_name" 
                           value="{{ old('full_name', $alumni->full_name) }}" required>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- IC Number --}}
                <div class="col-md-6 mb-3">
                    <label for="ic_number" class="form-label">IC Number</label>
                    <input type="text" class="form-control @error('ic_number') is-invalid @enderror" 
                           id="ic_number" name="ic_number" 
                           value="{{ old('ic_number', $alumni->ic_number) }}">
                    @error('ic_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                {{-- Gender --}}
                <div class="col-md-4 mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                        <option value="">-- Select Gender --</option>
                        <option value="male" {{ old('gender', $alumni->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $alumni->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Age --}}
                <div class="col-md-4 mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control @error('age') is-invalid @enderror" 
                           id="age" name="age" min="1" max="100" 
                           value="{{ old('age', $alumni->age) }}">
                    @error('age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contact Number --}}
                <div class="col-md-4 mb-3">
                    <label for="contact_number" class="form-label">Contact Number *</label>
                    <input type="text" class="form-control @error('contact_number') is-invalid @enderror" 
                           id="contact_number" name="contact_number" 
                           value="{{ old('contact_number', $alumni->contact_number) }}" required>
                    @error('contact_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="photo" class="form-label">Profile Photo</label>
                <div class="d-flex align-items-center gap-3">
                    @if ($alumni->photo)
                        <div>
                            <img src="{{ asset('storage/' . $alumni->photo) }}" alt="Current Photo" 
                                 class="img-thumbnail rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                               id="photo" name="photo" accept="image/*">
                        <div class="form-text small">Accepted formats: JPEG, PNG, JPG. Max size: 2MB</div>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- SECTION 2: Academic Background --}}
            <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Academic Background</h6>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="year_graduated" class="form-label">Year Graduated *</label>
                    <input type="number" class="form-control @error('year_graduated') is-invalid @enderror" 
                           id="year_graduated" name="year_graduated" min="2000" max="{{ date('Y') }}" 
                           value="{{ old('year_graduated', $alumni->year_graduated) }}" required>
                    @error('year_graduated')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="state" class="form-label">State</label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                           id="state" name="state" 
                           value="{{ old('state', $alumni->state) }}" placeholder="e.g. Selangor">
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="tadika_name" class="form-label">Tadika Name</label>
                    <input type="text" class="form-control @error('tadika_name') is-invalid @enderror" 
                           id="tadika_name" name="tadika_name" 
                           value="{{ old('tadika_name', $alumni->tadika_name) }}" placeholder="e.g. Tadika Kemas">
                    @error('tadika_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- SECTION 3: Professional Status --}}
            <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Professional Status</h6>

            <div class="mb-4">
                <div class="d-flex gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="current_status" id="studying" value="studying" 
                               {{ old('current_status', $alumni->current_status) === 'studying' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="studying">
                            <i class="fas fa-graduation-cap me-1 text-primary"></i> Studying
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="current_status" id="working" value="working" 
                               {{ old('current_status', $alumni->current_status) === 'working' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="working">
                            <i class="fas fa-briefcase me-1 text-primary"></i> Working
                        </label>
                    </div>
                </div>
            </div>

            {{-- Conditional: Studying --}}
            <div id="studying-fields" class="p-3 bg-light rounded border mb-3" style="display: none;">
                <div class="mb-0">
                    <label for="institution_name" class="form-label">Institution Name *</label>
                    <input type="text" class="form-control" id="institution_name" name="institution_name" 
                           value="{{ old('institution_name', $alumni->institution_name) }}">
                </div>
            </div>

            {{-- Conditional: Working --}}
            <div id="working-fields" class="p-3 bg-light rounded border mb-3" style="display: none;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="company_name" class="form-label">Company Name *</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" 
                               value="{{ old('company_name', $alumni->company_name) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="job_position" class="form-label">Job Title *</label>
                        <input type="text" class="form-control" id="job_position" name="job_position" 
                               value="{{ old('job_position', $alumni->job_position) }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $alumni->address) }}</textarea>
            </div>

            {{-- SECTION 4: Family Information --}}
            <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Family Information</h6>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="father_name" class="form-label">Father's Name</label>
                    <input type="text" class="form-control @error('father_name') is-invalid @enderror" 
                           id="father_name" name="father_name" 
                           value="{{ old('father_name', $alumni->father_name) }}">
                    @error('father_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="mother_name" class="form-label">Mother's Name</label>
                    <input type="text" class="form-control @error('mother_name') is-invalid @enderror" 
                           id="mother_name" name="mother_name" 
                           value="{{ old('mother_name', $alumni->mother_name) }}">
                    @error('mother_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label for="parent_contact" class="form-label">Parent Contact Number</label>
                    <input type="text" class="form-control @error('parent_contact') is-invalid @enderror" 
                           id="parent_contact" name="parent_contact" 
                           value="{{ old('parent_contact', $alumni->parent_contact) }}">
                    @error('parent_contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- SECTION 5: Security --}}
            <div class="alert alert-warning border-warning mt-4">
                <h6 class="alert-heading fw-bold"><i class="fas fa-lock me-2"></i>Change Password</h6>
                <p class="mb-3 small">Leave these fields blank if you do not wish to change your password.</p>

                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Re-type password">
                    </div>
                </div>
            </div>

        </div> {{-- End Card Body --}}

        <div class="card-footer bg-light d-flex justify-content-end gap-2 p-3">
            <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-1"></i> Update Profile
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

        // Initialize on load
        toggleFields();

        // Listen for changes
        if (studyingRadio) studyingRadio.addEventListener('change', toggleFields);
        if (workingRadio) workingRadio.addEventListener('change', toggleFields);
    });
</script>
@endpush