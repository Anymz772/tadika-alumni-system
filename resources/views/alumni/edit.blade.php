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
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-primary"><i class="fas fa-user-edit me-2"></i>Update Alumni Details</h5>
        </div>

        <form method="POST" action="{{ route('alumni.update', $alumni->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                {{-- Alert for Success/Errors --}}
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

                {{-- SECTION 1: Personal Information --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">Personal Information</h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control" name="full_name"
                            value="{{ old('full_name', $alumni->full_name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email', $alumni->email) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">IC Number *</label>
                        <input type="text" class="form-control" name="ic_number"
                            value="{{ old('ic_number', $alumni->ic_number) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Number *</label>
                        <input type="text" class="form-control" name="contact_number"
                            value="{{ old('contact_number', $alumni->contact_number) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">-- Select Gender --</option>
                            <option value="male" {{ old('gender', $alumni->gender) == 'male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="female" {{ old('gender', $alumni->gender) == 'female' ? 'selected' : '' }}>
                                Female</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" class="form-control" name="age" min="1" max="100"
                            value="{{ old('age', $alumni->age) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="state"
                            value="{{ old('state', $alumni->state) }}" placeholder="e.g. Selangor">
                    </div>
                </div>

                {{-- SECTION 2: Academic & Origin --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Academic & Origin</h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Year Graduated *</label>
                        <input type="number" class="form-control" name="year_graduated"
                            value="{{ old('year_graduated', $alumni->year_graduated) }}" min="2000"
                            max="{{ date('Y') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tadika Name</label>
                        <input type="text" class="form-control" name="tadika_name"
                            value="{{ old('tadika_name', $alumni->tadika_name) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Home Address *</label>
                    <textarea class="form-control" name="address" rows="2" required>{{ old('address', $alumni->address) }}</textarea>
                </div>

                {{-- SECTION 3: Current Status --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Current Status</h6>

                <div class="mb-4">
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="current_status" id="studying"
                                value="studying"
                                {{ old('current_status', $alumni->current_status) === 'studying' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="studying">
                                <i class="fas fa-graduation-cap me-1 text-primary"></i> Studying
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="current_status" id="working"
                                value="working"
                                {{ old('current_status', $alumni->current_status) === 'working' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="working">
                                <i class="fas fa-briefcase me-1 text-primary"></i> Working
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Conditional Fields --}}
                <div id="studying-fields" class="p-3 bg-light rounded border mb-3" style="display: none;">
                    <div class="mb-0">
                        <label for="institution_name" class="form-label fw-bold">Institution Name</label>
                        <input type="text" class="form-control" id="institution_name" name="institution_name"
                            value="{{ old('institution_name', $alumni->institution_name) }}">
                    </div>
                </div>

                <div id="working-fields" class="p-3 bg-light rounded border mb-3" style="display: none;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="company_name" class="form-label fw-bold">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name"
                                value="{{ old('company_name', $alumni->company_name) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="job_position" class="form-label fw-bold">Job Title</label>
                            <input type="text" class="form-control" id="job_position" name="job_position"
                                value="{{ old('job_position', $alumni->job_position) }}">
                        </div>
                    </div>
                </div>

                {{-- SECTION 4: Family Information --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Family Information
                </h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Father's Name</label>
                        <input type="text" class="form-control" name="father_name"
                            value="{{ old('father_name', $alumni->father_name) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mother's Name</label>
                        <input type="text" class="form-control" name="mother_name"
                            value="{{ old('mother_name', $alumni->mother_name) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Parent Contact</label>
                    <input type="text" class="form-control" name="parent_contact"
                        value="{{ old('parent_contact', $alumni->parent_contact) }}">
                </div>

                {{-- SECTION 5: Profile Photo --}}
                <div class="mb-3 border-top pt-3 mt-4">
                    <label class="form-label fw-bold">Profile Photo</label>
                    <div class="d-flex align-items-center gap-3">
                        @if ($alumni->photo)
                            <img src="{{ asset('storage/' . $alumni->photo) }}" alt="Current Photo"
                                class="img-thumbnail rounded-circle"
                                style="width: 80px; height: 80px; object-fit: cover;">
                        @endif
                        <div class="flex-grow-1">
                            <input type="file" class="form-control" name="photo" accept="image/*">
                            <div class="form-text">Leave blank if you don't want to change the photo. Max size: 2MB</div>
                        </div>
                    </div>
                </div>

            </div> {{-- End Card Body --}}

            <div class="card-footer bg-light d-flex justify-content-end gap-2 p-3">
                <a href="{{ route('alumni.show', $alumni->id) }}" class="btn btn-secondary">
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
                // Check if elements exist to prevent console errors
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

            // Run on load to set initial state based on DB data or Old Input
            toggleFields();

            // Listen for changes
            if (studyingRadio) studyingRadio.addEventListener('change', toggleFields);
            if (workingRadio) workingRadio.addEventListener('change', toggleFields);
        });
    </script>
@endpush