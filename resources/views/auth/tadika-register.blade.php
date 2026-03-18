@extends('layouts.public')

@section('title', 'Pendaftaran Tadika - Sistem Alumni Tadika')

@section('content')
<div class="reg-wrapper">
    <div class="reg-card">

        {{-- Header --}}
        <div class="reg-header">
            <div class="reg-icon">
                <i class="fas fa-school"></i>
            </div>
            <h2>Pendaftaran Tadika</h2>
            <p>Daftarkan Tadika anda untuk mengakses sistem</p>
        </div>

        {{-- Error Alert --}}
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> Sila betulkan ralat di bawah.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('tadika.register') }}" enctype="multipart/form-data">
            @csrf

            <div class="reg-body">

                {{-- Section 1: Maklumat Tadika --}}
                <div class="form-section">
                    <div class="section-label">
                        <span class="section-number">1</span>
                        <span class="section-title"><i class="fas fa-id-card me-2"></i>Maklumat Tadika</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="tadika_name" class="form-label required">Nama Tadika</label>
                            <input type="text"
                                class="form-control @error('tadika_name') is-invalid @enderror"
                                id="tadika_name" name="tadika_name"
                                value="{{ old('tadika_name') }}"
                                placeholder="Cth: Tadika Ceria Indah"
                                required>
                            @error('tadika_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tadika_reg_no" class="form-label required">No. Pendaftaran</label>
                            <input type="text"
                                class="form-control @error('tadika_reg_no') is-invalid @enderror"
                                id="tadika_reg_no" name="tadika_reg_no"
                                value="{{ old('tadika_reg_no') }}"
                                placeholder="Cth: JPN/2024/001"
                                required>
                            @error('tadika_reg_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 2: Lokasi --}}
                <div class="form-section">
                    <div class="section-label">
                        <span class="section-number">2</span>
                        <span class="section-title"><i class="fas fa-map-marker-alt me-2"></i>Lokasi</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="tadika_state" class="form-label required">Negeri</label>
                            <input type="text"
                                class="form-control @error('tadika_state') is-invalid @enderror"
                                id="tadika_state" name="tadika_state"
                                list="state-list"
                                value="{{ old('tadika_state') }}"
                                placeholder="Pilih negeri..."
                                required>
                            @error('tadika_state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <datalist id="state-list">
                                @foreach($states as $state)
                                    <option value="{{ $state }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="col-md-4">
                            <label for="tadika_district" class="form-label required">Daerah</label>
                            <input type="text"
                                class="form-control @error('tadika_district') is-invalid @enderror"
                                id="tadika_district" name="tadika_district"
                                list="district-list"
                                value="{{ old('tadika_district') }}"
                                placeholder="Pilih daerah..."
                                required>
                            @error('tadika_district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <datalist id="district-list"></datalist>
                        </div>

                        <div class="col-md-4">
                            <label for="tadika_postcode" class="form-label required">Poskod</label>
                            <input type="text"
                                class="form-control @error('tadika_postcode') is-invalid @enderror"
                                id="tadika_postcode" name="tadika_postcode"
                                list="postcode-list"
                                value="{{ old('tadika_postcode') }}"
                                placeholder="Pilih poskod..."
                                required>
                            @error('tadika_postcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <datalist id="postcode-list"></datalist>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Akaun --}}
                <div class="form-section">
                    <div class="section-label">
                        <span class="section-number">3</span>
                        <span class="section-title"><i class="fas fa-lock me-2"></i>Maklumat Akaun</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="tadika_email" class="form-label required">Emel Tadika</label>
                            <input type="email"
                                class="form-control @error('tadika_email') is-invalid @enderror"
                                id="tadika_email" name="tadika_email"
                                value="{{ old('tadika_email') }}"
                                placeholder="tadika@example.com"
                                required>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1 text-primary"></i>
                                Emel ini akan digunakan untuk log masuk ke sistem.
                            </div>
                            @error('tadika_email')
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

                {{-- Notice & Submit --}}
                <div class="reg-footer">
                    <div class="notice-box">
                        <i class="fas fa-check-circle notice-icon"></i>
                        <div>
                            <strong>Akaun sedia-merta</strong>
                            <p class="mb-0 text-muted small">Akaun Tadika anda akan dibuat serta-merta. Maklumat tambahan boleh dikemaskini selepas log masuk.</p>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label text-muted" for="terms">
                            Saya mengesahkan bahawa maklumat yang diberikan adalah tepat dan benar.
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-tadika-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i> Daftar Tadika
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

    /* ── Footer / CTA ──────────────────────────── */
    .reg-footer {
        margin-top: 0.5rem;
    }

    .notice-box {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        background: #e8f5e9;
        border: 1px solid #c8e6c9;
        border-radius: 10px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.25rem;
    }

    .notice-icon {
        color: #388e3c;
        font-size: 1.2rem;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .form-check-input:checked {
        background-color: #1a73e8;
        border-color: #1a73e8;
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

    // ── Location cascade ─────────────────────────
    const stateInput    = document.getElementById('tadika_state');
    const districtInput = document.getElementById('tadika_district');
    const postcodeInput = document.getElementById('tadika_postcode');
    const districtList  = document.getElementById('district-list');
    const postcodeList  = document.getElementById('postcode-list');

    stateInput.addEventListener('change', function () {
        const state = this.value.trim();
        districtInput.value = '';
        postcodeInput.value = '';
        districtList.innerHTML = '';
        postcodeList.innerHTML = '';

        if (state) {
            fetch(`{{ route('tadika.register.districts') }}?state=${encodeURIComponent(state)}`)
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
            fetch(`{{ route('tadika.register.postcodes') }}?district=${encodeURIComponent(district)}`)
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

    // ── Password visibility toggle ───────────────
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.dataset.target;
            const input    = document.getElementById(targetId);
            const icon     = this.querySelector('i');
            const isHidden = input.type === 'password';

            input.type      = isHidden ? 'text' : 'password';
            icon.className  = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    });

});
</script>
@endpush