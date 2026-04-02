@extends('layouts.cms')

@section('title', 'Tambah Tadika Baru - Tadika Alumni CMS')
@section('page-title', 'Tambah Tadika Baru')
@section('header-title', 'Tambah sebuah tadika ke dalam sistem')

@section('header-buttons')
    <a href="{{ route('tadika.index') }}" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-2">
            <h6 class="mb-0 text-primary"><i class="fas fa-school me-2"></i>Maklumat Tadika</h6>
        </div>

        <form method="POST" action="{{ route('tadika.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="card-body px-4 py-4">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6 class="alert-heading mb-1"><i class="fas fa-exclamation-circle me-2"></i>Ralat Pengesahan</h6>
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Maklumat Tadika --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">Maklumat Tadika</h6>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Nama Tadika <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('tadika_name') is-invalid @enderror"
                            name="tadika_name" value="{{ old('tadika_name') }}" required>
                        @error('tadika_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Nombor Pendaftaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('tadika_reg_no') is-invalid @enderror"
                            name="tadika_reg_no" value="{{ old('tadika_reg_no') }}" required>
                        @error('tadika_reg_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label form-label-sm">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm @error('tadika_address') is-invalid @enderror"
                            name="tadika_address" rows="3" required>{{ old('tadika_address') }}</textarea>
                        @error('tadika_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label form-label-sm">Negeri <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('tadika_state') is-invalid @enderror"
                               id="tadika_state" name="tadika_state" value="{{ old('tadika_state') }}"
                               list="tadika-state-list" placeholder="Pilih negeri..." required>
                        <div id="tadika_state_error" class="invalid-feedback"></div>
                        @error('tadika_state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <datalist id="tadika-state-list">
                            @foreach($states as $state)
                                <option value="{{ $state }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label form-label-sm">Daerah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('tadika_district') is-invalid @enderror"
                               id="tadika_district" name="tadika_district" value="{{ old('tadika_district') }}"
                               list="tadika-district-list" placeholder="Pilih daerah..." required>
                        <div id="tadika_district_error" class="invalid-feedback"></div>
                        @error('tadika_district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <datalist id="tadika-district-list"></datalist>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label form-label-sm">Poskod <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('tadika_postcode') is-invalid @enderror"
                               id="tadika_postcode" name="tadika_postcode" value="{{ old('tadika_postcode') }}"
                               list="tadika-postcode-list" placeholder="Pilih poskod..." required>
                        <div id="tadika_postcode_error" class="invalid-feedback"></div>
                        @error('tadika_postcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <datalist id="tadika-postcode-list"></datalist>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Nombor Telefon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('tadika_phone') is-invalid @enderror"
                            name="tadika_phone" value="{{ old('tadika_phone') }}" placeholder="cth., 0123456789" required>
                        @error('tadika_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Alamat E-mel <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-sm @error('tadika_email') is-invalid @enderror"
                            name="tadika_email" value="{{ old('tadika_email') }}" required>
                        @error('tadika_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Lokasi / Kawasan</label>
                        <input type="text" class="form-control form-control-sm @error('tadika_location') is-invalid @enderror"
                            name="tadika_location" value="{{ old('tadika_location') }}" placeholder="cth., Berhampiran Pusat Bandar">
                        @error('tadika_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Logo / Foto</label>
                        <input type="file" class="form-control form-control-sm @error('tadika_logo') is-invalid @enderror"
                            name="tadika_logo" accept="image/*">
                        <div class="form-text">Format: JPEG, PNG, JPG, GIF (Maks: 2MB)</div>
                        @error('tadika_logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Maklumat Akaun Pemilik --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-2">Maklumat Akaun Pemilik</h6>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Nama Pemilik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('owner_name') is-invalid @enderror"
                            name="owner_name" value="{{ old('owner_name') }}" required>
                        @error('owner_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Kata Laluan <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror"
                            name="password" required minlength="8">
                        <div class="form-text">Minimum 8 aksara</div>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Sahkan Kata Laluan <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" required minlength="8">
                        @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="alert alert-info small" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Nota:</strong> Pemilik akan dapat log masuk dengan e-mel dan kata laluan mereka untuk mengurus alumni tadika ini.
                </div>

            </div>

            <div class="card-footer bg-white py-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fas fa-save me-1"></i> Cipta Tadika
                    </button>
                    <a href="{{ route('tadika.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const stateInput = document.getElementById('tadika_state');
    const districtInput = document.getElementById('tadika_district');
    const postcodeInput = document.getElementById('tadika_postcode');
    const districtList = document.getElementById('tadika-district-list');
    const postcodeList = document.getElementById('tadika-postcode-list');

    const stateError = document.getElementById('tadika_state_error');
    const districtError = document.getElementById('tadika_district_error');
    const postcodeError = document.getElementById('tadika_postcode_error');
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

    form.addEventListener('submit', function (event) {
        const isStateValid = validateDatalistInput(stateInput, 'tadika-state-list', stateError);
        const isDistrictValid = validateDatalistInput(districtInput, 'tadika-district-list', districtError);
        const isPostcodeValid = validateDatalistInput(postcodeInput, 'tadika-postcode-list', postcodeError);

        if (!isStateValid || !isDistrictValid || !isPostcodeValid) {
            event.preventDefault();
        }
    });

    stateInput.addEventListener('change', function () {
        const state = this.value.trim();
        districtInput.value = '';
        postcodeInput.value = '';
        districtList.innerHTML = '';
        postcodeList.innerHTML = '';

        if (state) {
            fetch(`{{ route('admin.tadika.districts') }}?state=${encodeURIComponent(state)}`)
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
            fetch(`{{ route('admin.tadika.postcodes') }}?district=${encodeURIComponent(district)}`)
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
});
</script>
@endpush