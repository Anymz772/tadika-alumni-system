@extends('layouts.cms')

@section('title', 'Kemaskini Profil Tadika')
@section('page-title', 'Kemaskini Profil Tadika')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-2">
            <h6 class="mb-0 text-primary"><i class="fas fa-school me-2"></i>Profil Tadika</h6>
        </div>

        <div class="card-body px-4 py-4">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    Please fill out this field with the red " * "
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Pautan Pendaftaran Alumni --}}
            <div class="mb-4 p-3 bg-light border rounded">
                <label class="form-label form-label-sm mb-1">Pautan Pendaftaran Alumni</label>
                <p class="small text-muted mb-2">Kongsi pautan ini dengan alumni anda. Ia akan pra-isi butiran Tadika anda pada halaman pendaftaran mereka.</p>
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control form-control-sm"
                        value="{{ route('alumni.register', ['ref' => $tadika->tadika_id]) }}"
                        readonly id="alumniRegLink">
                    <button class="btn btn-sm btn-outline-secondary" type="button" onclick="copyToClipboard()">
                        <i class="fas fa-copy me-1"></i> Salin Pautan
                    </button>
                </div>
            </div>

            <form method="POST" action="{{ route('tadika.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Maklumat Tadika --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">Maklumat Tadika</h6>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Nama Tadika <span class="text-danger">*</span></label>
                        <input type="text" name="tadika_name"
                            class="form-control form-control-sm @error('tadika_name') is-invalid @enderror"
                            value="{{ old('tadika_name', $tadika->tadika_name ?? '') }}" required>
                        @error('tadika_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Nombor Pendaftaran <span class="text-danger">*</span></label>
                        <input type="text" name="tadika_reg_no"
                            class="form-control form-control-sm @error('tadika_reg_no') is-invalid @enderror"
                            value="{{ old('tadika_reg_no', $tadika->tadika_reg_no ?? '') }}" required>
                        @error('tadika_reg_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label form-label-sm">Alamat</label>
                        <textarea name="tadika_address"
                            class="form-control form-control-sm @error('tadika_address') is-invalid @enderror"
                            rows="3">{{ old('tadika_address', $tadika->tadika_address ?? '') }}</textarea>
                        @error('tadika_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label form-label-sm">Negeri <span class="text-danger">*</span></label>
                        <input type="text" name="tadika_state" id="tadika_state"
                               class="form-control form-control-sm @error('tadika_state') is-invalid @enderror"
                               list="state-list" placeholder="Pilih negeri..."
                               value="{{ old('tadika_state', $tadika->tadika_state ?? '') }}" required>
                        <div id="tadika_state_error" class="invalid-feedback"></div>
                        @error('tadika_state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <datalist id="state-list">
                            @foreach($states as $state)
                                <option value="{{ $state }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label form-label-sm">Daerah <span class="text-danger">*</span></label>
                        <input type="text" name="tadika_district" id="tadika_district"
                               class="form-control form-control-sm @error('tadika_district') is-invalid @enderror"
                               list="district-list" placeholder="Pilih daerah..."
                               value="{{ old('tadika_district', $tadika->tadika_district ?? '') }}" required>
                        <div id="tadika_district_error" class="invalid-feedback"></div>
                        @error('tadika_district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <datalist id="district-list"></datalist>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label form-label-sm">Poskod <span class="text-danger">*</span></label>
                        <input type="text" name="tadika_postcode" id="tadika_postcode"
                               class="form-control form-control-sm @error('tadika_postcode') is-invalid @enderror"
                               list="postcode-list" placeholder="Pilih poskod..."
                               value="{{ old('tadika_postcode', $tadika->tadika_postcode ?? '') }}" required>
                        <div id="tadika_postcode_error" class="invalid-feedback"></div>
                        @error('tadika_postcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <datalist id="postcode-list"></datalist>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Telefon</label>
                        <input type="text" name="tadika_phone"
                            class="form-control form-control-sm @error('tadika_phone') is-invalid @enderror"
                            value="{{ old('tadika_phone', $tadika->tadika_phone ?? '') }}" placeholder="cth., 0123456789">
                        @error('tadika_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-sm">E-mel</label>
                        <input type="email" name="tadika_email"
                            class="form-control form-control-sm @error('tadika_email') is-invalid @enderror"
                            value="{{ old('tadika_email', $tadika->tadika_email ?? '') }}">
                        @error('tadika_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Nama Pemilik / Pengetua</label>
                        <input type="text" name="tadika_owner"
                            class="form-control form-control-sm @error('tadika_owner') is-invalid @enderror"
                            value="{{ old('tadika_owner', $tadika->tadika_owner ?? '') }}">
                        @error('tadika_owner') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Lokasi / Kawasan</label>
                        <input type="text" name="tadika_location"
                            class="form-control form-control-sm @error('tadika_location') is-invalid @enderror"
                            value="{{ old('tadika_location', $tadika->tadika_location ?? '') }}" placeholder="cth., Berhampiran Pusat Bandar">
                        @error('tadika_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label form-label-sm">Gambar / Logo Tadika</label>
                        <input type="file" name="tadika_logo"
                            class="form-control form-control-sm @error('tadika_logo') is-invalid @enderror"
                            accept="image/*">
                        <div class="form-text">Format: JPEG, PNG, JPG, GIF (Maks: 2MB)</div>
                        @error('tadika_logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if (!empty($tadika?->tadika_logo))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $tadika->tadika_logo) }}"
                                    alt="Tadika Logo" style="max-height: 80px; border-radius: 4px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer bg-white px-0 pb-0 mt-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function copyToClipboard() {
        const copyText = document.getElementById("alumniRegLink");
        copyText.select();
        navigator.clipboard.writeText(copyText.value);
        alert("Pautan telah disalin ke papan keratan");
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const stateInput = document.getElementById('tadika_state');
        const districtInput = document.getElementById('tadika_district');
        const postcodeInput = document.getElementById('tadika_postcode');
        const districtList = document.getElementById('district-list');
        const postcodeList = document.getElementById('postcode-list');

        const stateError = document.getElementById('tadika_state_error');
        const districtError = document.getElementById('tadika_district_error');
        const postcodeError = document.getElementById('tadika_postcode_error');
        const errorMessage = "Maklumat lokasi tidak sah. Sila pastikan pilihan dibuat daripada senarai yang disediakan.";

        function validateDatalistInput(input, dataListId, errorDiv) {
            const value = input.value.trim();
            if (value) {
                const dataList = document.getElementById(dataListId);
                if (dataList.options.length === 0 && value) return true;
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

        function fetchDistricts(callback) {
            const state = stateInput.value.trim();
            districtList.innerHTML = '';
            if (state) {
                fetch(`{{ route('tadika.districts') }}?state=${encodeURIComponent(state)}`)
                    .then(r => r.json())
                    .then(data => {
                        data.forEach(district => {
                            const opt = document.createElement('option');
                            opt.value = district;
                            districtList.appendChild(opt);
                        });
                        if (callback) callback();
                    });
            }
        }

        function fetchPostcodes(callback) {
            const district = districtInput.value.trim();
            postcodeList.innerHTML = '';
            if (district) {
                fetch(`{{ route('tadika.postcodes') }}?district=${encodeURIComponent(district)}`)
                    .then(r => r.json())
                    .then(data => {
                        data.forEach(postcode => {
                            const opt = document.createElement('option');
                            opt.value = postcode;
                            postcodeList.appendChild(opt);
                        });
                        if (callback) callback();
                    });
            }
        }

        if (stateInput.value) {
            fetchDistricts(function () {
                if (districtInput.value) fetchPostcodes();
            });
        }

        stateInput.addEventListener('change', function () {
            districtInput.value = '';
            postcodeInput.value = '';
            postcodeList.innerHTML = '';
            fetchDistricts();
        });

        districtInput.addEventListener('change', function () {
            postcodeInput.value = '';
            fetchPostcodes();
        });

        form.addEventListener('submit', function (event) {
            const isStateValid = validateDatalistInput(stateInput, 'state-list', stateError);
            const isDistrictValid = validateDatalistInput(districtInput, 'district-list', districtError);
            const isPostcodeValid = validateDatalistInput(postcodeInput, 'postcode-list', postcodeError);

            if (!isStateValid || !isDistrictValid || !isPostcodeValid) {
                event.preventDefault();
            }
        });
    });
</script>
@endpush