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

                <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Negeri</label>
                    <input type="text" class="form-control @error('alumni_state') is-invalid @enderror" 
                           id="alumni_state" name="alumni_state" value="{{ old('alumni_state') }}"
                           list="alumni-state-list" placeholder="Pilih negeri...">
                    @error('alumni_state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="alumni_state_error" class="invalid-feedback"></div>
                    <datalist id="alumni-state-list">
                        @foreach($states as $state)
                            <option value="{{ $state }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Daerah</label>
                    <input type="text" class="form-control @error('alumni_district') is-invalid @enderror" 
                           id="alumni_district" name="alumni_district" value="{{ old('alumni_district') }}"
                           list="alumni-district-list" placeholder="Pilih daerah...">
                    @error('alumni_district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="alumni_district_error" class="invalid-feedback"></div>
                    <datalist id="alumni-district-list"></datalist>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Poskod</label>
                    <input type="text" class="form-control @error('alumni_postcode') is-invalid @enderror" 
                           id="alumni_postcode" name="alumni_postcode" value="{{ old('alumni_postcode') }}"
                           list="alumni-postcode-list" placeholder="Pilih poskod...">
                    @error('alumni_postcode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="alumni_postcode_error" class="invalid-feedback"></div>
                    <datalist id="alumni-postcode-list"></datalist>
                </div>
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

        // Location cascade
        const stateInput    = document.getElementById('alumni_state');
        const districtInput = document.getElementById('alumni_district');
        const postcodeInput = document.getElementById('alumni_postcode');
        const districtList  = document.getElementById('alumni-district-list');
        const postcodeList  = document.getElementById('alumni-postcode-list');

        stateInput.addEventListener('change', function () {
            const state = this.value.trim();
            districtInput.value = '';
            postcodeInput.value = '';
            districtList.innerHTML = '';
            postcodeList.innerHTML = '';

            if (state) {
                fetch(`{{ route('admin.alumni.districts') }}?state=${encodeURIComponent(state)}`)
                    .then(r => r.json())
                    .then(data => {
                        data.forEach(district => {
                            const opt = document.createElement('option');
                            opt.value = district;
                            districtList.appendChild(opt);
                        });
                    });
            }
        });

        districtInput.addEventListener('change', function () {
            const district = this.value.trim();
            postcodeInput.value = '';
            postcodeList.innerHTML = '';

            if (district) {
                fetch(`{{ route('admin.alumni.postcodes') }}?district=${encodeURIComponent(district)}`)
                    .then(r => r.json())
                    .then(data => {
                        data.forEach(postcode => {
                            const opt = document.createElement('option');
                            opt.value = postcode;
                            postcodeList.appendChild(opt);
                        });
                    });
            }
        });

        // Form validation
        const form = document.querySelector('form');
        const stateError = document.getElementById('alumni_state_error');
        const districtError = document.getElementById('alumni_district_error');
        const postcodeError = document.getElementById('alumni_postcode_error');
        const errorMessage = "Maklumat lokasi tidak sah. Sila pastikan pilihan dibuat daripada senarai yang disediakan.";

        function validateDatalistInput(input, dataListId, errorDiv) {
            const value = input.value.trim();
            if (value) {
                const dataList = document.getElementById(dataListId);
                let optionFound = false;
                for (const option of dataList.options) {
                    if (option.value.toLowerCase() === value.toLowerCase()) {
                        optionFound = true;
                        break;
                    }
                }
                if (!optionFound) {
                    input.classList.add('is-invalid');
                    errorDiv.textContent = errorMessage;
                    return false;
                }
            }
            input.classList.remove('is-invalid');
            errorDiv.textContent = '';
            return true;
        }

        form.addEventListener('submit', function(event) {
            const isStateValid = validateDatalistInput(stateInput, 'alumni-state-list', stateError);
            const isDistrictValid = validateDatalistInput(districtInput, 'alumni-district-list', districtError);
            const isPostcodeValid = validateDatalistInput(postcodeInput, 'alumni-postcode-list', postcodeError);

            if (!isStateValid || !isDistrictValid || !isPostcodeValid) {
                event.preventDefault();
            }
        });
    });
</script>
@endpush