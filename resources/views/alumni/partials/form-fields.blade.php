<h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">Maklumat Peribadi</h6>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Penuh *</label>
        <input type="text" class="form-control" name="alumni_name"
            value="{{ old('alumni_name', $alumni->alumni_name) }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Alamat E-mel *</label>
        <input type="email" class="form-control" name="user_email"
            value="{{ old('user_email', $alumni->user->user_email ?? $alumni->alumni_email) }}" required>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">No. IC *</label>
        <input type="text" class="form-control" name="alumni_ic"
            value="{{ old('alumni_ic', $alumni->alumni_ic) }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nombor Kenalan *</label>
        <input type="text" class="form-control" name="alumni_phone"
            value="{{ old('alumni_phone', $alumni->alumni_phone) }}" required>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Jantina</label>
        <select name="gender" class="form-control">
            <option value="">-- Pilih Jantina --</option>
            <option value="male" {{ old('gender', $alumni->gender) == 'male' ? 'selected' : '' }}>Lelaki</option>
            <option value="female" {{ old('gender', $alumni->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Umur</label>
        <input type="number" class="form-control" name="age" min="1" max="100"
            value="{{ old('age', $alumni->age) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">State</label>
        <input type="text" class="form-control" name="alumni_state"
            value="{{ old('alumni_state', $alumni->alumni_state) }}" placeholder="cth. Selangor">
    </div>
</div>

<h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Akademik & Asal</h6>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Tahun Graduasi</label>
        <input type="number" class="form-control" name="grad_year"
            value="{{ old('grad_year', $alumni->grad_year) }}" min="2000"
            max="{{ date('Y') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Tadika</label>
        <input type="text" class="form-control" name="tadika_name"
            value="{{ old('tadika_name', $alumni->tadika_name) }}">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Alamat Rumah *</label>
    <textarea class="form-control" name="alumni_address" rows="2" required>{{ old('alumni_address', $alumni->alumni_address) }}</textarea>
</div>

<h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Status Semasa</h6>

<div class="mb-4">
    <div class="d-flex gap-4">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="alumni_status" id="studying"
                value="studying" {{ old('alumni_status', $alumni->alumni_status) === 'studying' ? 'checked' : '' }}>
            <label class="form-check-label fw-bold" for="studying">
                <i class="fas fa-graduation-cap me-1 text-primary"></i> Sedang belajar
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="alumni_status" id="working"
                value="working" {{ old('alumni_status', $alumni->alumni_status) === 'working' ? 'checked' : '' }}>
            <label class="form-check-label fw-bold" for="working">
                <i class="fas fa-briefcase me-1 text-primary"></i> Bekerja
            </label>
        </div>
    </div>
</div>

<div id="studying-fields" class="p-3 bg-light rounded border mb-3" style="display: none;">
    <div class="mb-0">
        <label for="institution" class="form-label fw-bold">Nama Institusi</label>
        <input type="text" class="form-control" id="institution" name="institution"
            value="{{ old('institution', $alumni->institution) }}">
    </div>
</div>

<div id="working-fields" class="p-3 bg-light rounded border mb-3" style="display: none;">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="company" class="form-label fw-bold">Nama Syarikat</label>
            <input type="text" class="form-control" id="company" name="company"
                value="{{ old('company', $alumni->company) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="job_position" class="form-label fw-bold">Jawatan</label>
            <input type="text" class="form-control" id="job_position" name="job_position"
                value="{{ old('job_position', $alumni->job_position) }}">
        </div>
    </div>
</div>

<h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Maklumat Keluarga</h6>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Ayah</label>
        <input type="text" class="form-control" name="father_name"
            value="{{ old('father_name', $alumni->father_name) }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Ibu</label>
        <input type="text" class="form-control" name="mother_name"
            value="{{ old('mother_name', $alumni->mother_name) }}">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Kenalan Ibu Bapa</label>
    <input type="text" class="form-control" name="parent_phone"
        value="{{ old('parent_phone', $alumni->parent_phone) }}">
</div>

<div class="mb-3 border-top pt-3 mt-4">
    <label class="form-label fw-bold">Profile Photo</label>
    <div class="d-flex align-items-center gap-3">
        @if ($alumni->alumni_photo)
            <img src="{{ asset('storage/' . $alumni->alumni_photo) }}" alt="Current Photo"
                class="img-thumbnail rounded-circle"
                style="width: 80px; height: 80px; object-fit: cover;">
        @endif
        <div class="flex-grow-1">
            <input type="file" class="form-control" name="alumni_photo" accept="image/*">
            <div class="form-text">Kosongkan jika anda tidak mahu menukar foto. Saiz maks: 2MB</div>
        </div>
    </div>
</div>

