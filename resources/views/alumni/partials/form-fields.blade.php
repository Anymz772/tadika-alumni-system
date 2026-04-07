<h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">Maklumat Peribadi</h6>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label form-label-sm">Nama Penuh <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="alumni_name"
            value="{{ old('alumni_name', $alumni->alumni_name) }}" required
            title="Nama penuh alumni">
    </div>

    <div class="col-md-6">
        <label class="form-label form-label-sm">Alamat E-mel <span class="text-danger">*</span></label>
        <input type="email" class="form-control form-control-sm" name="user_email"
            value="{{ old('user_email', $alumni->user->user_email ?? $alumni->alumni_email) }}" required
            title="Alamat emel yang sah">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label form-label-sm">No. IC <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="alumni_ic"
            value="{{ old('alumni_ic', $alumni->alumni_ic) }}" required
            pattern="[0-9]{12}"
            maxlength="12"
            title="No IC mestilah 12 digit">
    </div>

    <div class="col-md-6">
        <label class="form-label form-label-sm">Nombor Kenalan <span class="text-danger">*</span></label>
        <input type="tel" class="form-control form-control-sm" name="alumni_phone"
            value="{{ old('alumni_phone', $alumni->alumni_phone) }}" required
            pattern="^\+?[\d\s\-\(\)]{10,15}$"
            title="No telefon sah (cth: 012-3456789 atau +60123456789)">
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
            value="{{ old('age', $alumni->age) }}"
            title="Umur antara 1-100 tahun">
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

<h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Lokasi Tadika</h6>

<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label form-label-sm">Negeri</label>
        <input type="text" class="form-control form-control-sm" 
                id="alumni_state" name="alumni_state" value="{{ old('alumni_state', $alumni->alumni_state) }}"
                list="alumni-state-list" placeholder="Pilih negeri...">
        <datalist id="alumni-state-list">
            @foreach($states as $state)
                <option value="{{ $state }}"></option>
            @endforeach
        </datalist>
    </div>

    <div class="col-md-4">
        <label class="form-label form-label-sm">Daerah</label>
        <input type="text" class="form-control form-control-sm"
                id="alumni_district" name="alumni_district" value="{{ old('alumni_district', $alumni->alumni_district) }}"
                list="alumni-district-list" placeholder="Pilih daerah...">
        <datalist id="alumni-district-list"></datalist>
    </div>

    <div class="col-md-4">
        <label class="form-label form-label-sm">Poskod</label>
        <input type="text" class="form-control form-control-sm"
                id="alumni_postcode" name="alumni_postcode" value="{{ old('alumni_postcode', $alumni->alumni_postcode) }}"
                list="alumni-postcode-list" placeholder="Pilih poskod..."
                pattern="^\d{5}$"
                title="Poskod mestilah 5 digit (cth: 56000)"
                maxlength="5">
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
        <input type="tel" class="form-control form-control-sm" name="parent_phone"
            value="{{ old('parent_phone', $alumni->parent_phone) }}"
            pattern="^\+?[\d\s\-\(\)]{10,15}$"
            title="No telefon ibu bapa sah">
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
