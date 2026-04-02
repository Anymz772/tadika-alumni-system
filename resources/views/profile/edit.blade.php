@extends('layouts.cms')

@section('title', 'Kemaskini Profil Saya')
@section('page-title', 'Kemaskini Profil')
@section('header-title', 'Kemaskini Profil Alumni Saya')
@section('header-subtitle', 'Kemaskini maklumat peribadi dan profesional anda')

@section('header-buttons')
    <a href="{{ route('profile.show') }}" class="btn btn-sm btn-info">
        <i class="fas fa-eye me-1"></i> Lihat Profil
    </a>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white py-2">
        @php
            $districts = \Illuminate\Support\Facades\DB::table('glo_bandar')
                ->whereNotNull('bandar_nama')
                ->distinct()
                ->orderBy('bandar_nama')
                ->pluck('bandar_nama');

            $postcodes = \Illuminate\Support\Facades\DB::table('glo_bandar')
                ->whereNotNull('bandar_postcode')
                ->distinct()
                ->orderBy('bandar_postcode')
                ->pluck('bandar_postcode');
        @endphp
        <h6 class="mb-0 text-primary"><i class="fas fa-user-edit me-2"></i>Kemaskini Profil</h6>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body px-4 py-4">

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    <i class="fas fa-exclamation-circle me-1"></i> Sila betulkan ralat di bawah.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Maklumat Peribadi --}}
            <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">Maklumat Peribadi</h6>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="alumni_name" class="form-label form-label-sm">Nama Penuh <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm @error('alumni_name') is-invalid @enderror"
                           id="alumni_name" name="alumni_name"
                           value="{{ old('alumni_name', $alumni->alumni_name) }}" required>
                    @error('alumni_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="alumni_ic" class="form-label form-label-sm">Nombor Kad Pengenalan</label>
                    <input type="text" class="form-control form-control-sm @error('alumni_ic') is-invalid @enderror"
                           id="alumni_ic" name="alumni_ic"
                           value="{{ old('alumni_ic', $alumni->alumni_ic) }}">
                    @error('alumni_ic') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="gender" class="form-label form-label-sm">Jantina</label>
                    <select name="gender" id="gender" class="form-control form-control-sm @error('gender') is-invalid @enderror">
                        <option value="">-- Pilih Jantina --</option>
                        <option value="male" {{ old('gender', $alumni->gender) == 'male' ? 'selected' : '' }}>Lelaki</option>
                        <option value="female" {{ old('gender', $alumni->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="age" class="form-label form-label-sm">Umur</label>
                    <input type="number" class="form-control form-control-sm @error('age') is-invalid @enderror"
                           id="age" name="age" min="1" max="100"
                           value="{{ old('age', $alumni->age) }}">
                    @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="alumni_phone" class="form-label form-label-sm">Nombor Telefon <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm @error('alumni_phone') is-invalid @enderror"
                           id="alumni_phone" name="alumni_phone"
                           value="{{ old('alumni_phone', $alumni->alumni_phone) }}" required>
                    @error('alumni_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Foto --}}
            <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-2">Foto</h6>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="alumni_photo" class="form-label form-label-sm">Gambar Profil</label>
                    <div class="d-flex align-items-center gap-3">
                        @if ($alumni->alumni_photo)
                            <img src="{{ asset('storage/' . $alumni->alumni_photo) }}" alt="Gambar Semasa"
                                 class="img-thumbnail rounded-circle"
                                 style="width: 70px; height: 70px; object-fit: cover;">
                        @endif
                        <div class="flex-grow-1">
                            <input type="file" class="form-control form-control-sm @error('alumni_photo') is-invalid @enderror"
                                   id="alumni_photo" name="alumni_photo" accept="image/*">
                            <div class="form-text">Format: JPEG, PNG, JPG. Maks: 2MB</div>
                            @error('alumni_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label form-label-sm">Gambar Kanak-Kanak</label>
                    <div class="d-flex align-items-center gap-3">
                        @if ($alumni->photo_childhood)
                            <img src="{{ asset('storage/' . $alumni->photo_childhood) }}" alt="Gambar Kanak-Kanak"
                                 class="img-thumbnail rounded"
                                 style="width: 70px; height: 70px; object-fit: cover;">
                        @endif
                        <div class="flex-grow-1">
                            <input type="file" class="form-control form-control-sm @error('photo_childhood') is-invalid @enderror"
                                   id="photo_childhood" name="photo_childhood" accept="image/*">
                            <div class="form-text">JPEG/PNG. Maks: 2MB</div>
                            @error('photo_childhood') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label form-label-sm">Gambar Terkini</label>
                    <div class="d-flex align-items-center gap-3">
                        @if ($alumni->photo_current)
                            <img src="{{ asset('storage/' . $alumni->photo_current) }}" alt="Gambar Terkini"
                                 class="img-thumbnail rounded"
                                 style="width: 70px; height: 70px; object-fit: cover;">
                        @endif
                        <div class="flex-grow-1">
                            <input type="file" class="form-control form-control-sm @error('photo_current') is-invalid @enderror"
                                   id="photo_current" name="photo_current" accept="image/*">
                            <div class="form-text">JPEG/PNG. Maks: 2MB</div>
                            @error('photo_current') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Latar Belakang Akademik --}}
            <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-2">Latar Belakang Akademik</h6>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="grad_year" class="form-label form-label-sm">Tahun Graduasi</label>
                    <input type="number" class="form-control form-control-sm @error('grad_year') is-invalid @enderror"
                           id="grad_year" name="grad_year" min="2000" max="{{ date('Y') }}"
                           value="{{ old('grad_year', $alumni->grad_year) }}">
                    @error('grad_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="alumni_state" class="form-label form-label-sm">Negeri</label>
                    <input type="text" class="form-control form-control-sm @error('alumni_state') is-invalid @enderror"
                           id="alumni_state" name="alumni_state"
                           value="{{ old('alumni_state', $alumni->alumni_state) }}" placeholder="cth. Selangor">
                    @error('alumni_state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label for="tadika_name" class="form-label form-label-sm">Nama Tadika</label>
                    <input type="text" class="form-control form-control-sm @error('tadika_name') is-invalid @enderror"
                           id="tadika_name" name="tadika_name"
                           value="{{ old('tadika_name', $alumni->tadika_name) }}" placeholder="cth. Tadika Kemas">
                    @error('tadika_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="alumni_district" class="form-label form-label-sm">Daerah</label>
                    <input type="text" class="form-control form-control-sm @error('alumni_district') is-invalid @enderror"
                           id="alumni_district" name="alumni_district" list="districtList"
                           value="{{ old('alumni_district', $alumni->alumni_district) }}" placeholder="Pilih atau taip daerah">
                    <datalist id="districtList">
                        @foreach($districts as $district)
                            <option value="{{ $district }}">
                        @endforeach
                    </datalist>
                    @error('alumni_district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="alumni_postcode" class="form-label form-label-sm">Poskod</label>
                    <input type="text" class="form-control form-control-sm @error('alumni_postcode') is-invalid @enderror"
                           id="alumni_postcode" name="alumni_postcode" list="postcodeList"
                           value="{{ old('alumni_postcode', $alumni->alumni_postcode) }}" placeholder="Pilih atau taip poskod">
                    <datalist id="postcodeList">
                        @foreach($postcodes as $postcode)
                            <option value="{{ $postcode }}">
                        @endforeach
                    </datalist>
                    @error('alumni_postcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Status Profesional --}}
            <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-2">Status Profesional</h6>

            <div class="mb-3">
                <div class="d-flex gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="alumni_status" id="studying" value="studying"
                               {{ old('alumni_status', $alumni->alumni_status) === 'studying' ? 'checked' : '' }}>
                        <label class="form-check-label" for="studying">
                            <i class="fas fa-graduation-cap me-1 text-primary"></i> Sedang Belajar
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="alumni_status" id="working" value="working"
                               {{ old('alumni_status', $alumni->alumni_status) === 'working' ? 'checked' : '' }}>
                        <label class="form-check-label" for="working">
                            <i class="fas fa-briefcase me-1 text-primary"></i> Bekerja
                        </label>
                    </div>
                </div>
            </div>

            <div id="studying-fields" class="p-3 bg-light rounded border mb-3" style="display: none;">
                <div class="mb-0">
                    <label for="institution" class="form-label form-label-sm">Nama Institusi</label>
                    <input type="text" class="form-control form-control-sm" id="institution" name="institution"
                           value="{{ old('institution', $alumni->institution) }}">
                </div>
            </div>

            <div id="working-fields" class="p-3 bg-light rounded border mb-3" style="display: none;">
                <div class="row mb-0">
                    <div class="col-md-6">
                        <label for="company" class="form-label form-label-sm">Nama Syarikat</label>
                        <input type="text" class="form-control form-control-sm" id="company" name="company"
                               value="{{ old('company', $alumni->company) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="job_position" class="form-label form-label-sm">Jawatan</label>
                        <input type="text" class="form-control form-control-sm" id="job_position" name="job_position"
                               value="{{ old('job_position', $alumni->job_position) }}">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="alumni_address" class="form-label form-label-sm">Alamat</label>
                    <textarea class="form-control form-control-sm" id="alumni_address" name="alumni_address" rows="3">{{ old('alumni_address', $alumni->alumni_address) }}</textarea>
                </div>
            </div>

            {{-- Maklumat Keluarga --}}
            <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-2">Maklumat Keluarga</h6>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="father_name" class="form-label form-label-sm">Nama Bapa</label>
                    <input type="text" class="form-control form-control-sm @error('father_name') is-invalid @enderror"
                           id="father_name" name="father_name"
                           value="{{ old('father_name', $alumni->father_name) }}">
                    @error('father_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="mother_name" class="form-label form-label-sm">Nama Ibu</label>
                    <input type="text" class="form-control form-control-sm @error('mother_name') is-invalid @enderror"
                           id="mother_name" name="mother_name"
                           value="{{ old('mother_name', $alumni->mother_name) }}">
                    @error('mother_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="parent_phone" class="form-label form-label-sm">Nombor Telefon Ibu Bapa</label>
                    <input type="text" class="form-control form-control-sm @error('parent_phone') is-invalid @enderror"
                           id="parent_phone" name="parent_phone"
                           value="{{ old('parent_phone', $alumni->parent_phone) }}">
                    @error('parent_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Tukar Kata Laluan --}}
            <div class="alert alert-warning border-warning mt-2">
                <h6 class="alert-heading fw-bold small"><i class="fas fa-lock me-2"></i>Tukar Kata Laluan</h6>
                <p class="mb-3 small">Biarkan kosong jika anda tidak mahu menukar kata laluan.</p>

                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label form-label-sm">Kata Laluan Baru</label>
                        <input type="password" name="password" class="form-control form-control-sm" placeholder="Minimum 8 aksara">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Sahkan Kata Laluan Baru</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Taip semula kata laluan">
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer bg-white py-3 d-flex justify-content-end gap-2">
            <a href="{{ route('profile.show') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-times me-1"></i> Batal
            </a>
            <button type="submit" class="btn btn-sm btn-primary px-4">
                <i class="fas fa-save me-1"></i> Kemaskini Profil
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
    });
</script>
@endpush