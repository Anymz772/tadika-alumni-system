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

        <form method="POST" action="{{ route('tadika.store') }}" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="card-body px-4 py-4">

                {{-- Maklumat Tadika --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">Maklumat Tadika</h6>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Nama Tadika <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm"
                            name="tadika_name" value="{{ old('tadika_name') }}" required
                            title="Nama penuh tadika">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Nombor Pendaftaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm"
                            name="tadika_reg_no" value="{{ old('tadika_reg_no') }}" required
                            title="Nombor pendaftaran rasmi tadika">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label form-label-sm">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm" name="tadika_address" rows="3" required>{{ old('tadika_address') }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label form-label-sm">Negeri <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm"
                               id="tadika_state" name="tadika_state" value="{{ old('tadika_state') }}"
                               list="tadika-state-list" placeholder="Pilih negeri..." required
                               title="Pilih negeri daripada senarai">
                        <datalist id="tadika-state-list">
                            @foreach($states as $state)
                                <option value="{{ $state }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label form-label-sm">Daerah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm"
                               id="tadika_district" name="tadika_district" value="{{ old('tadika_district') }}"
                               list="tadika-district-list" placeholder="Pilih daerah..." required
                               title="Pilih daerah daripada senarai">
                        <datalist id="tadika-district-list"></datalist>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Nombor Telefon <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control form-control-sm"
                            name="tadika_phone" value="{{ old('tadika_phone') }}" placeholder="cth., 0123456789" required
                            pattern="^\+?[\d\s\-\(\)]{10,15}$"
                            title="No telefon sah (cth: 012-3456789 atau +60123456789)">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Alamat E-mel <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-sm"
                            name="tadika_email" value="{{ old('tadika_email') }}" required
                            title="Alamat emel tadika yang sah">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Lokasi / Kawasan</label>
                        <input type="text" class="form-control form-control-sm"
                            name="tadika_location" value="{{ old('tadika_location') }}" placeholder="cth., Berhampiran Pusat Bandar">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Logo / Foto</label>
                        <input type="file" class="form-control form-control-sm"
                            name="tadika_logo" accept="image/*">
                        <div class="form-text">Format: JPEG, PNG, JPG, GIF (Maks: 2MB)</div>
                    </div>
                </div>

                {{-- Maklumat Akaun Pemilik --}}
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-2">Maklumat Akaun Pemilik</h6>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Nama Pemilik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm"
                            name="owner_name" value="{{ old('owner_name') }}" required
                            title="Nama penuh pemilik tadika">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Kata Laluan <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-sm"
                            name="password" required minlength="8"
                            title="Kata laluan sekurang-kurangnya 8 aksara">
                        <div class="form-text">Minimum 8 aksara</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label form-label-sm">Sahkan Kata Laluan <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-sm"
                            name="password_confirmation" required minlength="8"
                            title="Sahkan kata laluan pemilik">
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
    const stateInput = document.getElementById('tadika_state');
    const districtInput = document.getElementById('tadika_district');
    const postcodeInput = document.getElementById('tadika_postcode');
    const districtList = document.getElementById('tadika-district-list');
    const postcodeList = document.getElementById('tadika-postcode-list');

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

@push('styles')
<style>
    .form-control:invalid {
        border-color: #dc3545;
    }
</style>
@endpush

