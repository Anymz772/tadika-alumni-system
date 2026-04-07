@extends('layouts.cms')

@section('title', 'Tambah Tadika Baru - Tadika Alumni CMS')
@section('page-title', 'Tambah Tadika Baru')
@section('header-title', 'Tambah tadika')

@section('header-buttons')
    <a href="{{ route('tadika.index') }}" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 text-primary fw-bold">
                <i class="fas fa-school me-2"></i>Maklumat Tadika
            </h6>
        </div>

        <form method="POST" action="{{ route('tadika.store') }}" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="card-body px-4 py-4">

                {{-- Makluman Ralat Keseluruhan --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> Sila betulkan ralat pada borang di bawah.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Bahagian 1: Maklumat Tadika --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">
                    <i class="fas fa-id-card me-1"></i> Maklumat Tadika
                </h6>

                <div class="row g-3 mb-4">
                    {{-- Kategori --}}
                    <div class="col-md-6">
                        <label for="tadika_category_id" class="form-label form-label-sm required">Kategori Tadika</label>
                        <select class="form-select form-select-sm @error('tadika_category_id') is-invalid @enderror" 
                            id="tadika_category_id" name="tadika_category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('tadika_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                            <option value="lain_lain" {{ old('tadika_category_id') == 'lain_lain' ? 'selected' : '' }}>Lain-lain</option>
                        </select>
                        @error('tadika_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Input Lain-lain --}}
                        <div id="new_category_wrapper" class="mt-2" style="display: {{ old('tadika_category_id') == 'lain_lain' ? 'block' : 'none' }};">
                            <input type="text" class="form-control form-control-sm @error('new_category_name') is-invalid @enderror" 
                                id="new_category_name" name="new_category_name" value="{{ old('new_category_name') }}" 
                                placeholder="Sila nyatakan kategori baharu...">
                            @error('new_category_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                                        {{-- Nama Pengusaha --}}
                    <div class="col-md-6">
                        <label for="tadika_owner" class="form-label form-label-sm required">Nama Pemilik / Pengusaha</label>
                        <input type="text" class="form-control form-control-sm @error('tadika_owner') is-invalid @enderror"
                            id="tadika_owner" name="tadika_owner" value="{{ old('tadika_owner') }}" 
                            placeholder="Nama penuh pemilik tadika" required>
                        @error('tadika_owner')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama Berdaftar --}}
                    <div class="col-md-12">
                        <label for="tadika_registered_name" class="form-label form-label-sm required">Nama Berdaftar (SSM/Lesen)</label>
                        <input type="text" class="form-control form-control-sm @error('tadika_registered_name') is-invalid @enderror"
                            id="tadika_registered_name" name="tadika_registered_name" value="{{ old('tadika_registered_name') }}" 
                            placeholder="Cth: Syarikat Ceria Sdn Bhd" required>
                        @error('tadika_registered_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama Komersial --}}
                    <div class="col-md-12">
                        <label for="tadika_name" class="form-label form-label-sm required">Nama Tadika</label>
                        <input type="text" class="form-control form-control-sm @error('tadika_name') is-invalid @enderror"
                            id="tadika_name" name="tadika_name" value="{{ old('tadika_name') }}" 
                            placeholder="Cth: Tadika Ceria Indah" required>
                        @error('tadika_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Bahagian 2: Lokasi & Perhubungan --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">
                    <i class="fas fa-map-marker-alt me-1"></i> Lokasi & Perhubungan
                </h6>

                <div class="row g-3 mb-4">
                    {{-- Negeri --}}
                    <div class="col-md-6">
                        <label for="tadika_state" class="form-label form-label-sm required">Negeri</label>
                        <select class="form-select form-select-sm @error('tadika_state') is-invalid @enderror"
                            id="tadika_state" name="tadika_state" required>
                            <option value="">-- Pilih Negeri --</option>
                            @foreach($states as $state)
                                <option value="{{ $state }}" {{ old('tadika_state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                            @endforeach
                        </select>
                        @error('tadika_state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Daerah --}}
                    <div class="col-md-6">
                        <label for="tadika_district" class="form-label form-label-sm required">Daerah</label>
                        <input type="text" class="form-control form-control-sm @error('tadika_district') is-invalid @enderror"
                            id="tadika_district" name="tadika_district" list="tadika-district-list"
                            value="{{ old('tadika_district') }}" placeholder="Pilih daerah..." required>
                        <datalist id="tadika-district-list"></datalist>
                        @error('tadika_district')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Alamat --}}
                    <div class="col-12">
                        <label for="tadika_address" class="form-label form-label-sm required">Alamat Penuh</label>
                        <textarea class="form-control form-control-sm @error('tadika_address') is-invalid @enderror" 
                            id="tadika_address" name="tadika_address" rows="2" required
                            placeholder="Alamat penuh premis tadika">{{ old('tadika_address') }}</textarea>
                        @error('tadika_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                                        {{-- No Telefon --}}
                    <div class="col-md-6">
                        <label for="tadika_phone" class="form-label form-label-sm required">No. Telefon Pejabat</label>
                        <input type="tel" class="form-control form-control-sm @error('tadika_phone') is-invalid @enderror"
                            id="tadika_phone" name="tadika_phone" value="{{ old('tadika_phone') }}" 
                            placeholder="Cth: 0312345678" required>
                        @error('tadika_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Logo --}}
                    <div class="col-md-6">
                        <label for="tadika_logo" class="form-label form-label-sm">Logo Tadika</label>
                        <input type="file" class="form-control form-control-sm @error('tadika_logo') is-invalid @enderror"
                            id="tadika_logo" name="tadika_logo" accept="image/*">
                        <div class="form-text" style="font-size: 0.75rem;">Format: JPEG, PNG, JPG. Maksimum: 2MB</div>
                        @error('tadika_logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Bahagian 3: Maklumat Akaun Sistem --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">
                    <i class="fas fa-lock me-1"></i> Maklumat Akaun (Log Masuk)
                </h6>
                
                <div class="alert alert-info py-2" style="font-size: 0.85rem;" role="alert">
                    <i class="fas fa-info-circle me-2"></i> Pemilik akan log masuk menggunakan e-mel dan kata laluan di bawah.
                </div>

                <div class="row g-3 mb-2">
                    {{-- Emel --}}
                    <div class="col-md-12">
                        <label for="tadika_email" class="form-label form-label-sm required">Alamat E-mel</label>
                        <input type="email" class="form-control form-control-sm @error('tadika_email') is-invalid @enderror"
                            id="tadika_email" name="tadika_email" value="{{ old('tadika_email') }}" 
                            placeholder="emel@contoh.com" required>
                        @error('tadika_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6">
                        <label for="password" class="form-label form-label-sm required">Kata Laluan</label>
                        <input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Minimum 8 aksara" required minlength="8">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label form-label-sm required">Sahkan Kata Laluan</label>
                        <input type="password" class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation" placeholder="Ulang kata laluan" required minlength="8">
                    </div>
                </div>

            </div>

            <div class="card-footer bg-light py-3 px-4">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('tadika.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Pendaftaran
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<style>
    .required::after {
        content: " *";
        color: #dc3545;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const stateInput = document.getElementById('tadika_state');
    const districtInput = document.getElementById('tadika_district');
    const districtList = document.getElementById('tadika-district-list');

    // -- Skrip untuk Cascade Negeri -> Daerah --
    if (stateInput) {
        stateInput.addEventListener('change', function () {
            const state = this.value.trim();
            districtInput.value = '';
            districtList.innerHTML = '';

            if (state) {
                fetch(`{{ route('admin.tadika.districts') }}?state=${encodeURIComponent(state)}`)
                    .then(r => r.json())
                    .then(data => {
                        data.forEach(district => {
                            const opt = document.createElement('option');
                            opt.value = district;
                            districtList.appendChild(opt);
                        });
                    })
                    .catch(() => console.error("Gagal menarik data daerah."));
            }
        });
    }

    // -- Skrip untuk Kategori "Lain-lain" --
    const categorySelect = document.getElementById('tadika_category_id');
    const newCategoryWrapper = document.getElementById('new_category_wrapper');
    const newCategoryInput = document.getElementById('new_category_name');

    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            if (this.value === 'lain_lain') {
                newCategoryWrapper.style.display = 'block';
                newCategoryInput.setAttribute('required', 'required');
                newCategoryInput.focus();
            } else {
                newCategoryWrapper.style.display = 'none';
                newCategoryInput.removeAttribute('required');
                newCategoryInput.value = '';
            }
        });
    }
});
</script>
@endpush