@extends('layouts.cms')

@section('title', 'Tambah Alumni Baru')
@section('page-title', 'Tambah Alumni')
@section('header-title', 'Tambah Alumni Baru')

@section('header-buttons')
    <a href="{{ route('alumni.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Tambah Alumni Baru</h5>
    </div>

    <form method="POST" action="{{ route('alumni.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            
            <h6 class="fw-bold mb-3 text-primary">Maklumat Peribadi</h6>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Penuh *</label>
                    <input type="text" class="form-control @error('alumni_name') is-invalid @enderror" 
                           name="alumni_name" value="{{ old('alumni_name') }}" required>
                    @error('alumni_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Alamat Emel</label>
                    <input type="email" class="form-control @error('user_email') is-invalid @enderror" 
                           name="user_email" value="{{ old('user_email') }}" required>
                    @error('user_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. Telefon</label>
                    <input type="text" class="form-control @error('alumni_phone') is-invalid @enderror" 
                           name="alumni_phone" value="{{ old('alumni_phone') }}" required>
                    @error('alumni_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">No. Kad Pengenalan</label>
                    <input type="text" class="form-control @error('alumni_ic') is-invalid @enderror" 
                           name="alumni_ic" value="{{ old('alumni_ic') }}" required>
                    @error('alumni_ic')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="gender" class="form-label">Jantina</label>
                    <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                        <option value="">-- Pilih Jantina --</option>
                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Lelaki</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="age" class="form-label">Umur</label>
                    <input type="number" class="form-control @error('age') is-invalid @enderror" 
                           name="age" min="1" max="100" value="{{ old('age') }}">
                    @error('age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat *</label>
                <textarea class="form-control @error('alumni_address') is-invalid @enderror" name="alumni_address" rows="2" required>{{ old('alumni_address') }}</textarea>
                @error('alumni_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>
            
            <h6 class="fw-bold mb-3 text-primary">Akademik & Latar Belakang</h6>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tahun Graduation</label>
                    <input type="number" class="form-control @error('grad_year') is-invalid @enderror" 
                           name="grad_year" min="2000" max="{{ date('Y') }}" value="{{ old('grad_year') }}">
                    @error('grad_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Nama Tadika</label>
                    <select class="form-control @error('tadika_id') is-invalid @enderror" id="tadika_id" name="tadika_id">
                        <option value="">Pilih Tadika</option>
                        @foreach ($tadikas as $tadika)
                            <option value="{{ $tadika->tadika_id }}" {{ old('tadika_id') == $tadika->tadika_id ? 'selected' : '' }}>
                                {{ $tadika->tadika_name }}
                            </option>
                        @endforeach
                        <option value="other" {{ old('tadika_id') == 'other' ? 'selected' : '' }}>Lain-lain</option>
                    </select>
                    @error('tadika_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3" id="other_tadika_name_div" style="display: none;">
                    <label for="other_tadika_name" class="form-label">Sila nyatakan Nama Tadika</label>
                    <input type="text" class="form-control @error('other_tadika_name') is-invalid @enderror"
                           id="other_tadika_name" name="other_tadika_name" value="{{ old('other_tadika_name') }}">
                    @error('other_tadika_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Negeri</label>
                    <input type="text" class="form-control @error('alumni_state') is-invalid @enderror" 
                           name="alumni_state" value="{{ old('alumni_state') }}">
                    @error('alumni_state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>
            
            <h6 class="fw-bold mb-3 text-primary">Status Pekerjaan / Pengajian</h6>
            
            <div class="mb-4">
                <div class="d-flex gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="alumni_status" id="studying" 
                               value="studying" {{ old('alumni_status') === 'studying' ? 'checked' : '' }}>
                        <label class="form-check-label" for="studying">
                            <i class="fas fa-graduation-cap me-1"></i> Belajar
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="alumni_status" id="working" 
                               value="working" {{ old('alumni_status') === 'working' ? 'checked' : '' }}>
                        <label class="form-check-label" for="working">
                            <i class="fas fa-briefcase me-1"></i> Bekerja
                        </label>
                    </div>
                </div>
                @error('alumni_status')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div id="studying-fields" class="mb-3" style="display: none;">
                <label for="institution" class="form-label fw-bold">Nama Institusi</label>
                <input type="text" class="form-control @error('institution') is-invalid @enderror" 
                       id="institution" name="institution" value="{{ old('institution') }}">
                @error('institution')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="working-fields" style="display: none;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="company" class="form-label fw-bold">Nama Syarikat</label>
                        <input type="text" class="form-control @error('company') is-invalid @enderror" 
                               id="company" name="company" value="{{ old('company') }}">
                        @error('company')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="job_position" class="form-label fw-bold">Jawatan</label>
                        <input type="text" class="form-control @error('job_position') is-invalid @enderror" 
                               id="job_position" name="job_position" value="{{ old('job_position') }}">
                        @error('job_position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>
            
            <h6 class="fw-bold mb-3 text-primary">Maklumat Keluarga</h6>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Ayah</label>
                    <input type="text" class="form-control @error('father_name') is-invalid @enderror" 
                           name="father_name" value="{{ old('father_name') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Ibu</label>
                    <input type="text" class="form-control @error('mother_name') is-invalid @enderror" 
                           name="mother_name" value="{{ old('mother_name') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">No. Telefon Ibu Bapa</label>
                    <input type="text" class="form-control @error('parent_phone') is-invalid @enderror" 
                           name="parent_phone" value="{{ old('parent_phone') }}">
                </div>
            </div>

            <hr>
            
            <h6 class="fw-bold mb-3 text-primary">Keselamatan & Media</h6>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kata Laluan *</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Sahkan Kata Laluan *</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Profil</label>
                <input type="file" class="form-control @error('alumni_photo') is-invalid @enderror" name="alumni_photo" accept="image/*">
                <div class="form-text">Accepted formats: JPEG, PNG, JPG. Max size: 2MB</div>
                @error('alumni_photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-2"></i> Simpan Alumni
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tadikaSelect = document.getElementById('tadika_id');
        const otherTadikaDiv = document.getElementById('other_tadika_name_div');

        function toggleOtherTadika() {
            if (tadikaSelect.value === 'other') {
                otherTadikaDiv.style.display = 'block';
            } else {
                otherTadikaDiv.style.display = 'none';
            }
        }

        // Initial check
        toggleOtherTadika();

        // Event listener
        tadikaSelect.addEventListener('change', toggleOtherTadika);
        
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