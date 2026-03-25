@extends('layouts.public')

@section('title', 'Pendaftaran Alumni - Sistem Alumni Tadika')

@section('content')
<div class="reg-wrapper">
    <div class="reg-card">

        {{-- Header --}}
        <div class="reg-header">
            <div class="reg-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h2>Pendaftaran Alumni</h2>
            <p>Cipta akaun anda untuk menyertai Rangkaian Alumni Tadika</p>
        </div>

        {{-- Error Alert --}}
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mx-4 mt-3" user_role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> Sila betulkan ralat di bawah.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('alumni.register') }}">
            @csrf

            <div class="reg-body">

                {{-- Section 1: Maklumat Akaun --}}
                <div class="form-section">
                    <div class="section-label">
                        <span class="section-number">1</span>
                        <span class="section-title"><i class="fas fa-user me-2"></i>Maklumat Akaun</span>
                    </div>

                    <div class="notice-box notice-info mb-3">
                        <i class="fas fa-info-circle notice-icon text-primary"></i>
                        <p class="mb-0 small">Hanya maklumat asas diperlukan. Maklumat tambahan boleh dilengkapkan selepas pendaftaran melalui halaman profil anda.</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="alumni_name" class="form-label required">Nama Penuh</label>
                            <input type="text"
                                class="form-control @error('alumni_name') is-invalid @enderror"
                                id="alumni_name" name="alumni_name"
                                value="{{ old('alumni_name') }}"
                                placeholder="Nama penuh anda"
                                required>
                            @error('alumni_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="user_email" class="form-label required">Alamat Emel</label>
                            <input type="email"
                                class="form-control @error('user_email') is-invalid @enderror"
                                id="user_email" name="user_email"
                                value="{{ old('user_email') }}"
                                placeholder="anda@example.com"
                                required>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1 text-primary"></i>
                                Alamat emel akan digunakan untuk log masuk.
                            </div>
                            @error('user_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label required">Kata Laluan</label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password"
                                    placeholder="Masukkan kata laluan"
                                    required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label required">Sahkan Kata Laluan</label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Ulang kata laluan"
                                    required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Maklumat Tadika --}}
                <div class="form-section">
                    <div class="section-label">
                        <span class="section-number">2</span>
                        <span class="section-title"><i class="fas fa-school me-2"></i>Maklumat Tadika</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="alumni_state" class="form-label required">Negeri</label>
                            <input type="text"
                                class="form-control @error('alumni_state') is-invalid @enderror"
                                id="alumni_state" name="alumni_state"
                                list="alumni-state-list"
                                value="{{ old('alumni_state', $prefilledTadika->tadika_state ?? '') }}"
                                placeholder="Pilih negeri..."
                                required>
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

                        <div class="col-md-4">
                            <label for="alumni_district" class="form-label required">Daerah</label>
                            <input type="text"
                                class="form-control @error('alumni_district') is-invalid @enderror"
                                id="alumni_district" name="alumni_district"
                                list="alumni-district-list"
                                value="{{ old('alumni_district', $prefilledTadika->tadika_district ?? '') }}"
                                placeholder="Pilih daerah..."
                                required>
                            @error('alumni_district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                             <div id="alumni_district_error" class="invalid-feedback"></div>
                            <datalist id="alumni-district-list"></datalist>
                        </div>

                        <div class="col-md-4">
                            <label for="alumni_postcode" class="form-label required">Poskod</label>
                            <input type="text"
                                class="form-control @error('alumni_postcode') is-invalid @enderror"
                                id="alumni_postcode" name="alumni_postcode"
                                list="alumni-postcode-list"
                                value="{{ old('alumni_postcode', $prefilledTadika->tadika_postcode ?? '') }}"
                                placeholder="Pilih poskod..."
                                required>
                            @error('alumni_postcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                             <div id="alumni_postcode_error" class="invalid-feedback"></div>
                            <datalist id="alumni-postcode-list"></datalist>
                        </div>

                        <div class="col-md-12">
                            <label for="tadika_id" class="form-label required">Nama Tadika</label>
                            <select class="form-control form-select @error('tadika_id') is-invalid @enderror"
                                id="tadika_id" name="tadika_id" required>
                                <option value="">-- Pilih Tadika --</option>
                                <option value="other" {{ old('tadika_id') == 'other' ? 'selected' : '' }}>Lain-lain (Others)</option>
                            </select>
                            @error('tadika_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12" id="other_tadika_name_div" style="display: none;">
                            <label for="other_tadika_name" class="form-label">Sila nyatakan Nama Tadika</label>
                            <input type="text"
                                class="form-control @error('other_tadika_name') is-invalid @enderror"
                                id="other_tadika_name" name="other_tadika_name"
                                value="{{ old('other_tadika_name') }}"
                                placeholder="Nama tadika anda">
                            @error('other_tadika_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Notice & Submit --}}
                <div class="reg-footer">
                    <div class="notice-box notice-success">
                        <i class="fas fa-check-circle notice-icon"></i>
                        <div>
                            <strong>Pendaftaran Pantas!</strong>
                            <p class="mb-0 text-muted small">Akaun anda akan dibuat serta-merta. Log masuk dan lengkapkan maklumat tambahan di profil anda kemudian.</p>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label text-muted" for="terms">
                            Saya bersetuju bahawa maklumat yang diberikan adalah tepat dan saya memberi persetujuan untuk menyertai Rangkaian Alumni Tadika.
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-tadika-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i> Cipta Akaun
                        </button>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i> Batal
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ── Layout ────────────────────────────────── */
    .reg-wrapper {
        display: flex;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .reg-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 780px;
        overflow: hidden;
    }

    /* ── Header ────────────────────────────────── */
    .reg-header {
        background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
        color: #fff;
        text-align: center;
        padding: 2.5rem 2rem;
    }

    .reg-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin: 0 auto 1rem;
    }

    .reg-header h2 {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .reg-header p {
        opacity: 0.85;
        margin: 0;
        font-size: 0.95rem;
    }

    /* ── Body ──────────────────────────────────── */
    .reg-body {
        padding: 2rem;
    }

    /* ── Form Sections ─────────────────────────── */
    .form-section {
        background: #f8f9fb;
        border: 1px solid #e8eaf0;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .section-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #dde1ea;
    }

    .section-number {
        width: 28px;
        height: 28px;
        background: #1a73e8;
        color: #fff;
        border-radius: 50%;
        font-size: 0.8rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .section-title {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
    }

    /* ── Form Controls ─────────────────────────── */
    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.4rem;
    }

    .required::after {
        content: " *";
        color: #dc3545;
    }

    .form-control {
        border-radius: 8px;
        border-color: #ced4da;
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.12);
    }

    .form-text {
        font-size: 0.8rem;
        margin-top: 0.35rem;
    }

    /* ── Password Toggle ───────────────────────── */
    .input-group .btn-outline-secondary {
        border-color: #ced4da;
        color: #6c757d;
        border-radius: 0 8px 8px 0 !important;
    }

    .input-group .form-control {
        border-radius: 8px 0 0 8px !important;
    }

    /* ── Notice Boxes ──────────────────────────── */
    .notice-box {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        border-radius: 10px;
        padding: 1rem 1.25rem;
    }

    .notice-success {
        background: #e8f5e9;
        border: 1px solid #c8e6c9;
        margin-bottom: 1.25rem;
    }

    .notice-info {
        background: #e3f2fd;
        border: 1px solid #bbdefb;
    }

    .notice-icon {
        font-size: 1.1rem;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .notice-success .notice-icon { color: #388e3c; }

    /* ── Footer / CTA ──────────────────────────── */
    .reg-footer {
        margin-top: 0.5rem;
    }

    .form-check-input:checked {
        background-color: #1a73e8;
        border-color: #1a73e8;
    }

    .form-control.form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right .75rem center;
        background-size: 16px 12px;
        appearance: none;
    }

    /* ── Buttons ───────────────────────────────── */
    .btn-tadika-primary {
        background: linear-gradient(135deg, #1a73e8, #0d47a1);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        letter-spacing: 0.3px;
        transition: opacity 0.2s, transform 0.1s;
    }

    .btn-tadika-primary:hover {
        opacity: 0.92;
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-outline-secondary {
        border-radius: 10px;
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('form');
    const stateInput = document.getElementById('alumni_state');
    const districtInput = document.getElementById('alumni_district');
    const postcodeInput = document.getElementById('alumni_postcode');
    const tadikaSelect  = document.getElementById('tadika_id');
    const districtList  = document.getElementById('alumni-district-list');
    const postcodeList  = document.getElementById('alumni-postcode-list');
    const otherDiv      = document.getElementById('other_tadika_name_div');

    const stateError = document.getElementById('alumni_state_error');
    const districtError = document.getElementById('alumni_district_error');
    const postcodeError = document.getElementById('alumni_postcode_error');
    const errorMessage = "Maklumat lokasi tidak sah.";

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

    function resetTadikaSelect() {
        tadikaSelect.innerHTML = '<option value="">-- Pilih Tadika --</option><option value="other">Lain-lain (Others)</option>';
    }

    function fetchDistricts() {
        const state = stateInput.value.trim();
        districtInput.value = '';
        postcodeInput.value = '';
        districtList.innerHTML = '';
        postcodeList.innerHTML = '';
        resetTadikaSelect();

        if (state) {
            fetch(`{{ route('alumni.register.districts') }}?state=${encodeURIComponent(state)}`)
                .then(r => r.json())
                .then(data => {
                    data.forEach(d => {
                        const opt = document.createElement('option');
                        opt.value = d;
                        districtList.appendChild(opt);
                    });
                });
        }
    }

    function fetchPostcodes() {
        const district = districtInput.value.trim();
        postcodeInput.value = '';
        postcodeList.innerHTML = '';
        resetTadikaSelect();

        if (district) {
            fetch(`{{ route('alumni.register.postcodes') }}?district=${encodeURIComponent(district)}`)
                .then(r => r.json())
                .then(data => {
                    data.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p;
                        postcodeList.appendChild(opt);
                    });
                });
        }
    }

    function fetchTadikas() {
        const state    = stateInput.value.trim();
        const district = districtInput.value.trim();
        const postcode = postcodeInput.value.trim();
        resetTadikaSelect();

        if (state && district && postcode) {
            fetch(`{{ route('alumni.register.tadikas') }}?state=${encodeURIComponent(state)}&district=${encodeURIComponent(district)}&postcode=${encodeURIComponent(postcode)}`)
                .then(r => r.json())
                .then(data => {
                    const other = tadikaSelect.querySelector('option[value="other"]');
                    data.forEach(tadika => {
                        const opt = document.createElement('option');
                        opt.value = tadika.tadika_id;
                        opt.textContent = tadika.tadika_name;
                        tadikaSelect.insertBefore(opt, other);
                    });
                });
        }
    }

    function toggleOtherTadika() {
        otherDiv.style.display = tadikaSelect.value === 'other' ? 'block' : 'none';
    }

    stateInput.addEventListener('change', fetchDistricts);
    districtInput.addEventListener('change', fetchPostcodes);
    postcodeInput.addEventListener('change', fetchTadikas);
    tadikaSelect.addEventListener('change', toggleOtherTadika);

    // ── Password visibility toggle ───────────────
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            const icon  = this.querySelector('i');
            const show  = input.type === 'password';
            input.type     = show ? 'text' : 'password';
            icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    });

    toggleOtherTadika();
});
</script>
@endpush