<h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">Maklumat Peribadi</h6>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label form-label-sm">Nama Penuh <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="alumni_name"
            value="{{ old('alumni_name', $alumni->alumni_name) }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label form-label-sm">Alamat E-mel <span class="text-danger">*</span></label>
        <input type="email" class="form-control form-control-sm" name="user_email"
            value="{{ old('user_email', $alumni->user->user_email ?? $alumni->alumni_email) }}" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label form-label-sm">No. IC <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="alumni_ic"
            value="{{ old('alumni_ic', $alumni->alumni_ic) }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label form-label-sm">Nombor Kenalan <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="alumni_phone"
            value="{{ old('alumni_phone', $alumni->alumni_phone) }}" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label form-label-sm">Jantina</label>
        <select name="gender" class="form-control form-control-sm">
            <option value="">-- Pilih Jantina --</option>
            <option value="male" {{ old('gender', $alumni->gender) == 'male' ? 'selected' : '' }}>Lelaki</option>
            <option value="female" {{ old('gender', $alumni->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label form-label-sm">Umur</label>
        <input type="number" class="form-control form-control-sm" name="age" min="1" max="100"
            value="{{ old('age', $alumni->age) }}">
    </div>
</div>

<h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Akademik & Asal</h6>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label form-label-sm">Tahun Graduasi</label>
        <input type="number" class="form-control form-control-sm" name="grad_year"
            value="{{ old('grad_year', $alumni->grad_year) }}" min="2000" max="{{ date('Y') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label form-label-sm">Nama Tadika</label>
        <input type="text" class="form-control form-control-sm" name="tadika_name"
            value="{{ old('tadika_name', $alumni->tadika_name) }}">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label form-label-sm">Negeri</label>
        <input type="text" class="form-control form-control-sm @error('alumni_state') is-invalid @enderror"
                id="alumni_state" name="alumni_state" value="{{ old('alumni_state', $alumni->alumni_state) }}"
                list="alumni-state-list" placeholder="Pilih negeri...">
        <div id="alumni_state_error" class="invalid-feedback"></div>
        @error('alumni_state') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <datalist id="alumni-state-list">
            @foreach($states as $state)
                <option value="{{ $state }}"></option>
            @endforeach
        </datalist>
    </div>

    <div class="col-md-4">
        <label class="form-label form-label-sm">Daerah</label>
        <input type="text" class="form-control form-control-sm @error('alumni_district') is-invalid @enderror"
                id="alumni_district" name="alumni_district" value="{{ old('alumni_district', $alumni->alumni_district) }}"
                list="alumni-district-list" placeholder="Pilih daerah...">
        <div id="alumni_district_error" class="invalid-feedback"></div>
        @error('alumni_district') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <datalist id="alumni-district-list"></datalist>
    </div>

    <div class="col-md-4">
        <label class="form-label form-label-sm">Poskod</label>
        <input type="text" class="form-control form-control-sm @error('alumni_postcode') is-invalid @enderror"
                id="alumni_postcode" name="alumni_postcode" value="{{ old('alumni_postcode', $alumni->alumni_postcode) }}"
                list="alumni-postcode-list" placeholder="Pilih poskod...">
        <div id="alumni_postcode_error" class="invalid-feedback"></div>
        @error('alumni_postcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <datalist id="alumni-postcode-list"></datalist>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label class="form-label form-label-sm">Alamat Rumah <span class="text-danger">*</span></label>
        <textarea class="form-control form-control-sm" name="alumni_address" rows="2" required>{{ old('alumni_address', $alumni->alumni_address) }}</textarea>
    </div>
</div>

<h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Status Semasa</h6>

<div class="mb-3">
    <div class="d-flex gap-4">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="alumni_status" id="studying"
                value="studying" {{ old('alumni_status', $alumni->alumni_status) === 'studying' ? 'checked' : '' }}>
            <label class="form-check-label" for="studying">
                <i class="fas fa-graduation-cap me-1 text-primary"></i> Sedang belajar
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="alumni_status" id="working"
                value="working" {{ old('alumni_status', $alumni->alumni_status) === 'working' ? 'checked' : '' }}>
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

<h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Maklumat Keluarga</h6>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label form-label-sm">Nama Ayah</label>
        <input type="text" class="form-control form-control-sm" name="father_name"
            value="{{ old('father_name', $alumni->father_name) }}">
    </div>

    <div class="col-md-6">
        <label class="form-label form-label-sm">Nama Ibu</label>
        <input type="text" class="form-control form-control-sm" name="mother_name"
            value="{{ old('mother_name', $alumni->mother_name) }}">
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label class="form-label form-label-sm">Kenalan Ibu Bapa</label>
        <input type="text" class="form-control form-control-sm" name="parent_phone"
            value="{{ old('parent_phone', $alumni->parent_phone) }}">
    </div>
</div>

<h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Foto Profil</h6>

<div class="row mb-3">
    <div class="col-12">
        <label class="form-label form-label-sm">Gambar Profil</label>
        <div class="d-flex align-items-center gap-3">
            @if ($alumni->alumni_photo)
                <img src="{{ asset('storage/' . $alumni->alumni_photo) }}" alt="Current Photo"
                    class="img-thumbnail rounded-circle"
                    style="width: 70px; height: 70px; object-fit: cover;">
            @endif
            <div class="flex-grow-1">
                <input type="file" class="form-control form-control-sm" name="alumni_photo" accept="image/*">
                <div class="form-text">Kosongkan jika tidak mahu menukar foto. Maks: 2MB</div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label form-label-sm">Childhood Photo</label>
        <div class="d-flex align-items-center gap-3">
            @if ($alumni->photo_childhood)
                <img src="{{ asset('storage/' . $alumni->photo_childhood) }}" alt="Childhood Photo"
                    class="img-thumbnail"
                    style="width: 70px; height: 70px; object-fit: cover;">
            @endif
            <div class="flex-grow-1">
                <input type="file" class="form-control form-control-sm" name="photo_childhood" accept="image/*">
                <div class="form-text">Kosongkan jika tidak mahu menukar foto. Maks: 2MB</div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label form-label-sm">Current Photo</label>
        <div class="d-flex align-items-center gap-3">
            @if ($alumni->photo_current)
                <img src="{{ asset('storage/' . $alumni->photo_current) }}" alt="Current Photo"
                    class="img-thumbnail"
                    style="width: 70px; height: 70px; object-fit: cover;">
            @endif
            <div class="flex-grow-1">
                <input type="file" class="form-control form-control-sm" name="photo_current" accept="image/*">
                <div class="form-text">Kosongkan jika tidak mahu menukar foto. Maks: 2MB</div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const stateInput = document.getElementById('alumni_state');
    const districtInput = document.getElementById('alumni_district');
    const postcodeInput = document.getElementById('alumni_postcode');
    const districtList = document.getElementById('alumni-district-list');
    const postcodeList = document.getElementById('alumni-postcode-list');

    const stateError = document.getElementById('alumni_state_error');
    const districtError = document.getElementById('alumni_district_error');
    const postcodeError = document.getElementById('alumni_postcode_error');
    const errorMessage = "Maklumat lokasi tidak sah. Sila pastikan pilihan dibuat daripada senarai yang disediakan.";

    let districtsRoute, postcodesRoute;
    const currentPath = window.location.pathname;

    if (currentPath.includes('/admin/alumni') || currentPath.includes('/alumni/')) {
        districtsRoute = "{{ route('admin.alumni.districts') }}";
        postcodesRoute = "{{ route('admin.alumni.postcodes') }}";
    } else if (currentPath.includes('/tadika/')) {
        districtsRoute = "{{ route('tadika.districts') }}";
        postcodesRoute = "{{ route('tadika.postcodes') }}";
    }

    function validateDatalistInput(input, dataListId, errorDiv) {
        const value = input.value.trim();
        if (value) {
            const dataList = document.getElementById(dataListId);
            if (dataList.options.length === 0) return true;
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
        if (state && districtsRoute) {
            fetch(`${districtsRoute}?state=${encodeURIComponent(state)}`)
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
        if (district && postcodesRoute) {
            fetch(`${postcodesRoute}?district=${encodeURIComponent(district)}`)
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
        fetchDistricts();
    });

    districtInput.addEventListener('change', function () {
        postcodeInput.value = '';
        fetchPostcodes();
    });

    form.addEventListener('submit', function (event) {
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