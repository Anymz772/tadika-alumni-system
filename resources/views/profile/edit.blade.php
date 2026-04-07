@extends('layouts.cms')

@section('title', 'Kemaskini Profil Saya')
@section('page-title', 'Kemaskini Profil')
@section('header-title', 'Kemaskini Profil Alumni Saya')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* Base UI Settings */
    :root {
        --bg-body: #f8fafc;
        --card-bg: #ffffff;
        --border-color: #e2e8f0;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --primary: #6366f1;
        --primary-hover: #4f46e5;
    }

    /* BODY */
    body {
        background-color: var(--bg-body);
        font-family: 'Inter', sans-serif;
        color: var(--text-main);
    }

    /* CARD (Premium SaaS style) */
    .card {
        background: #fff;
        border: 1px solid #eef2f7;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        margin-bottom: 2rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
    }

    /* HEADER */
    .card-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 1.25rem 1.75rem;
        background: transparent;
    }

    .card-title {
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background-color: #f1f5f9;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    /* BODY SPACING */
    .card-body {
        padding: 1.75rem;
    }

    /* FORM LABEL (Improved Spacing & Readability) */
    .form-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #475569; /* Darker for better contrast */
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 0.65rem; /* Increased spacing */
        display: block;
    }

    /* INPUT */
    .form-control, .form-select {
        padding: 0.75rem 1rem;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        font-size: 0.9rem;
        color: #1e293b;
        transition: all 0.2s;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    /* BUTTONS */
    .btn-primary-custom {
        background-color: var(--primary);
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        padding: 0.7rem 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
        transition: all 0.2s;
    }

    .btn-primary-custom:hover {
        background-color: var(--primary-hover);
        box-shadow: 0 6px 8px -1px rgba(99, 102, 241, 0.3);
        transform: translateY(-1px);
        color: #fff;
    }

    .btn-outline-custom {
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #475569;
        font-weight: 500;
        border-radius: 10px;
        padding: 0.7rem 1.5rem;
        transition: all 0.2s;
    }

    .btn-outline-custom:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #94a3b8;
    }

    /* IMAGE */
    .profile-img-box {
        width: 130px;
        height: 130px;
        border-radius: 20px;
        border: 3px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        margin: 0 auto 1.5rem auto;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        background: #f8fafc;
    }

    .profile-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 17px;
    }

    .profile-img-box .remove-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 28px;
        height: 28px;
        background: #ef4444;
        color: white;
        border: 2px solid white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .profile-img-box .remove-btn:hover {
        transform: scale(1.1);
        background: #dc2626;
    }

    /* MINI IMAGE */
    .mini-photo-upload {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        background: #f8fafc;
        padding: 1rem;
        border-radius: 12px;
        border: 1px dashed #cbd5e1;
    }

    .mini-preview {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        background: #fff;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .mini-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* RADIO PILLS */
    .status-pills .btn-check + .btn {
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        font-weight: 500;
        transition: all 0.2s;
    }

    .status-pills .btn-check:checked + .btn {
        background-color: var(--primary);
        border-color: var(--primary);
        color: #fff;
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
    }

    /* SOFT DIVIDER */
    .soft-divider {
        border-top: 1px dashed #cbd5e1;
        margin: 2rem 0;
        opacity: 0.5;
    }

    /* SPACING UTILITIES */
    .field-spacing {
        margin-bottom: 1.5rem;
    }

    .form-group-spacing {
        margin-bottom: 1.75rem;
    }

    /* CARD HEADER VARIATIONS */
    .card-header-about .card-icon { background-color: #fef3c7; color: #d97706; }
    .card-header-photo .card-icon { background-color: #ecfdf5; color: #10b981; }
    .card-header-academic .card-icon { background-color: #eef2ff; color: #6366f1; }
    .card-header-professional .card-icon { background-color: #fffbeb; color: #f59e0b; }
    .card-header-family .card-icon { background-color: #f0fdfa; color: #14b8a6; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    @php
        $districts = \Illuminate\Support\Facades\DB::table('glo_bandar')->whereNotNull('bandar_nama')->distinct()->orderBy('bandar_nama')->pluck('bandar_nama');
        $postcodes = \Illuminate\Support\Facades\DB::table('glo_bandar')->whereNotNull('bandar_postcode')->distinct()->orderBy('bandar_postcode')->pluck('bandar_postcode');
    @endphp

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show small rounded-3 shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> Sila semak ruangan yang bertanda " * " merah.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show small rounded-3 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            
            {{-- LEFT COLUMN: ACCOUNT (Image & Password) --}}
            <div class="col-xl-3 col-lg-4">
                
                {{-- Account Settings Card --}}
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-uppercase fw-bold text-muted mb-4 text-center" style="font-size: 0.75rem; letter-spacing: 0.08em;">
                            Account Settings
                        </h6>
                        
                        <div class="text-center mb-4">
                            <div class="profile-img-box">
                                @if ($alumni->alumni_photo)
                                    <img src="{{ asset('storage/' . $alumni->alumni_photo) }}" alt="Profile">
                                @else
                                    <i class="fas fa-user fa-3x" style="color: #cbd5e1;"></i>
                                @endif
                                <button type="button" class="remove-btn" title="Remove Photo"><i class="fas fa-times"></i></button>
                            </div>
                            
                            <input type="file" id="alumni_photo" name="alumni_photo" class="d-none" accept="image/*">
                            <button type="button" class="btn btn-outline-custom w-100" onclick="document.getElementById('alumni_photo').click();">
                                <i class="fas fa-camera me-2"></i> Upload Photo
                            </button>
                            @error('alumni_photo') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="soft-divider"></div>

                        <div class="field-spacing">
                            <label class="form-label">Old Password</label>
                            <input type="password" name="old_password" class="form-control" placeholder="Enter current password">
                        </div>
                        <div class="field-spacing">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Min. 8 characters">
                        </div>
                        <div class="field-spacing">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Retype new password">
                        </div>
                        <button type="submit" class="btn btn-outline-custom w-100 fw-semibold">
                            <i class="fas fa-key me-2"></i> Change Password
                        </button>
                    </div>
                </div>

                {{-- About the User Card --}}
                <div class="card mt-4">
                    <div class="card-header d-flex align-items-center gap-3" card-header-about">
                        <div class="card-icon"><i class="fas fa-heart"></i></div>
                        <h6 class="card-title">About The User</h6>
                    </div>
                    <div class="card-body">
                        <div class="field-spacing">
                            <label class="form-label">Hobby / Interests</label>
                            <input type="text" class="form-control" name="hobby" value="{{ old('hobby', $alumni->hobby ?? '') }}" placeholder="e.g. Reading, Swimming, Photography">
                            <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">Separate multiple hobbies with commas</small>
                        </div>
                        <div class="field-spacing">
                            <label class="form-label">Favourite Things</label>
                            <input type="text" class="form-control" name="favourite_things" value="{{ old('favourite_things', $alumni->favourite_things ?? '') }}" placeholder="e.g. Music, Coffee, Traveling">
                            <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">Things you love or enjoy the most</small>
                        </div>
                        <div>
                            <label class="form-label">Short Bio / About Me</label>
                            <textarea class="form-control" name="bio" rows="4" placeholder="Tell us a little about yourself...">{{ old('bio', $alumni->bio ?? '') }}</textarea>
                            <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">Share your story, background, or what makes you unique</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: MAIN FORMS --}}
            <div class="col-xl-9 col-lg-8">
                
                {{-- Personal Info Card --}}
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center gap-3"">
                        <div class="card-icon"><i class="fas fa-user"></i></div>
                        <h6 class="card-title">Personal Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alumni_name" value="{{ old('alumni_name', $alumni->alumni_name) }}" placeholder="Your full name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">IC Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alumni_ic" value="{{ old('alumni_ic', $alumni->alumni_ic) }}" placeholder="e.g. 990101-01-1234" required>
                            </div>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="male" {{ old('gender', $alumni->gender) == 'male' ? 'selected' : '' }}>Lelaki</option>
                                    <option value="female" {{ old('gender', $alumni->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Age <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="age" value="{{ old('age', $alumni->age) }}" placeholder="e.g. 25" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alumni_phone" value="{{ old('alumni_phone', $alumni->alumni_phone) }}" placeholder="e.g. 012-3456789" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Photos Card --}}
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center gap-3" card-header-photo">
                        <div class="card-icon"><i class="fas fa-image"></i></div>
                        <h6 class="card-title">Gallery Photos</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Childhood Photo</label>
                                <div class="mini-photo-upload">
                                    <div class="mini-preview">
                                        @if ($alumni->photo_childhood)
                                            <img src="{{ asset('storage/' . $alumni->photo_childhood) }}" alt="Child">
                                        @else
                                            <span style="font-size: 1.75rem;">🧒</span>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control form-control-sm" name="photo_childhood" accept="image/*">
                                        <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">JPEG / PNG · Max 2MB</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Recent Photo</label>
                                <div class="mini-photo-upload">
                                    <div class="mini-preview">
                                        @if ($alumni->photo_current)
                                            <img src="{{ asset('storage/' . $alumni->photo_current) }}" alt="Recent">
                                        @else
                                            <span style="font-size: 1.75rem;">😊</span>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control form-control-sm" name="photo_current" accept="image/*">
                                        <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">JPEG / PNG · Max 2MB</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Academic Background Card --}}
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center gap-3" card-header-academic">
                        <div class="card-icon"><i class="fas fa-graduation-cap"></i></div>
                        <h6 class="card-title">Academic Background</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Graduation Year <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="grad_year" value="{{ old('grad_year', $alumni->grad_year) }}" placeholder="e.g. 2010" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Kindergarten Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="tadika_name" value="{{ old('tadika_name', $alumni->tadika_name) }}" placeholder="e.g. Tadika Kemas" required>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alumni_state" value="{{ old('alumni_state', $alumni->alumni_state) }}" placeholder="e.g. Selangor" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">District <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alumni_district" list="districtList" value="{{ old('alumni_district', $alumni->alumni_district) }}" placeholder="Type or select" required>
                                <datalist id="districtList">
                                    @foreach($districts as $district) <option value="{{ $district }}"></option> @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Postcode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alumni_postcode" list="postcodeList" value="{{ old('alumni_postcode', $alumni->alumni_postcode) }}" placeholder="e.g. 47810" required>
                                <datalist id="postcodeList">
                                    @foreach($postcodes as $postcode) <option value="{{ $postcode }}"></option> @endforeach
                                </datalist>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Professional Status Card --}}
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center gap-3" card-header-professional">
                        <div class="card-icon"><i class="fas fa-briefcase"></i></div>
                        <h6 class="card-title">Professional Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group-spacing">
                            <label class="form-label">Current Status <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3 status-pills">
                                <div>
                                    <input type="radio" class="btn-check" name="alumni_status" id="studying" value="studying" {{ old('alumni_status', $alumni->alumni_status) === 'studying' ? 'checked' : '' }} required>
                                    <label class="btn" for="studying"><i class="fas fa-book-reader me-2"></i>Studying</label>
                                </div>
                                <div>
                                    <input type="radio" class="btn-check" name="alumni_status" id="working" value="working" {{ old('alumni_status', $alumni->alumni_status) === 'working' ? 'checked' : '' }} required>
                                    <label class="btn" for="working"><i class="fas fa-laptop-code me-2"></i>Working</label>
                                </div>
                            </div>
                        </div>

                        <div id="studying-fields" class="form-group-spacing" style="display: none;">
                            <label class="form-label">Institution Name</label>
                            <input type="text" class="form-control" name="institution" value="{{ old('institution', $alumni->institution) }}" placeholder="e.g. Universiti Malaya">
                        </div>

                        <div id="working-fields" class="form-group-spacing" style="display: none;">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control" name="company" value="{{ old('company', $alumni->company) }}" placeholder="e.g. Petronas">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Job Position</label>
                                    <input type="text" class="form-control" name="job_position" value="{{ old('job_position', $alumni->job_position) }}" placeholder="e.g. Software Engineer">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="alumni_address" rows="3" placeholder="Your current address...">{{ old('alumni_address', $alumni->alumni_address) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Family Information Card --}}
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center gap-3" card-header-family">
                        <div class="card-icon"><i class="fas fa-users"></i></div>
                        <h6 class="card-title">Family Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Father's Name</label>
                                <input type="text" class="form-control" name="father_name" value="{{ old('father_name', $alumni->father_name) }}" placeholder="Father's full name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mother's Name</label>
                                <input type="text" class="form-control" name="mother_name" value="{{ old('mother_name', $alumni->mother_name) }}" placeholder="Mother's full name">
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Parent's Phone Number</label>
                                <input type="text" class="form-control" name="parent_phone" value="{{ old('parent_phone', $alumni->parent_phone) }}" placeholder="e.g. 012-3456789">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-end gap-3 mt-2 mb-5">
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-custom">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save me-1"></i> Update Profile
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Dynamic Fields for Status
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

        toggleFields();
        if (studyingRadio) studyingRadio.addEventListener('change', toggleFields);
        if (workingRadio) workingRadio.addEventListener('change', toggleFields);
        
        // Remove photo functionality
        const removeBtn = document.querySelector('.remove-btn');
        const profileImgBox = document.querySelector('.profile-img-box');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove your profile photo?')) {
                    const removeInput = document.createElement('input');
                    removeInput.type = 'hidden';
                    removeInput.name = 'remove_photo';
                    removeInput.value = '1';
                    document.querySelector('form').appendChild(removeInput);
                    profileImgBox.innerHTML = '<i class="fas fa-user fa-3x" style="color: #cbd5e1;"></i>';
                }
            });
        }
    });
</script>
@endpush