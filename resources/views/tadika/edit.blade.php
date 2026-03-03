@extends('layouts.cms')

@section('title', 'Sunting Tadika - ' . $tadika->tadika_name)
@section('page-title', 'Sunting Tadika')
@section('header-title', 'Sunting: ' . $tadika->tadika_name')

@section('header-buttons')
    <a href="{{ route('tadika.show', $tadika->tadika_id) }}" class="btn btn-info me-2">
        <i class="fas fa-eye me-2"></i> Lihat
    </a>
    <a href="{{ route('tadika.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-primary"><i class="fas fa-school me-2"></i>Kemaskini Butiran Tadika</h5>
        </div>

        <form method="POST" action="{{ route('tadika.update', $tadika->tadika_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading"><i class="fas fa-exclamation-circle me-2"></i>Ralat Validasi</h5>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Tadika Information Section -->
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2">Maklumat Tadika</h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Tadika *</label>
                        <input type="text" class="form-control @error('tadika_name') is-invalid @enderror" 
                            name="tadika_name" value="{{ old('tadika_name', $tadika->tadika_name) }}" required>
                        @error('tadika_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombor Pendaftaran *</label>
                        <input type="text" class="form-control @error('tadika_reg_no') is-invalid @enderror"
                            name="tadika_reg_no" value="{{ old('tadika_reg_no', $tadika->tadika_reg_no) }}" required>
                        @error('tadika_reg_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat *</label>
                        <textarea class="form-control @error('tadika_address') is-invalid @enderror" 
                            name="tadika_address" rows="3" required>{{ old('tadika_address', $tadika->tadika_address) }}</textarea>
                        @error('tadika_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Daerah *</label>
                        <input type="text" class="form-control @error('tadika_district') is-invalid @enderror"
                            name="tadika_district" value="{{ old('tadika_district', $tadika->tadika_district) }}" required>
                        @error('tadika_district') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Negeri *</label>
                        <input type="text" class="form-control @error('tadika_state') is-invalid @enderror"
                            name="tadika_state" value="{{ old('tadika_state', $tadika->tadika_state) }}" required>
                        @error('tadika_state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Poskod *</label>
                        <input type="text" class="form-control @error('tadika_postcode') is-invalid @enderror"
                            name="tadika_postcode" value="{{ old('tadika_postcode', $tadika->tadika_postcode) }}" required>
                        @error('tadika_postcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombor Telefon *</label>
                        <input type="text" class="form-control @error('tadika_phone') is-invalid @enderror"
                            name="tadika_phone" value="{{ old('tadika_phone', $tadika->tadika_phone) }}" required>
                        @error('tadika_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Alamat E-mel *</label>
                        <input type="email" class="form-control @error('tadika_email') is-invalid @enderror"
                            name="tadika_email" value="{{ old('tadika_email', $tadika->tadika_email) }}" required>
                        @error('tadika_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lokasi/Kawasan</label>
                        <input type="text" class="form-control @error('tadika_location') is-invalid @enderror"
                            name="tadika_location" value="{{ old('tadika_location', $tadika->tadika_location) }}">
                        @error('tadika_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Logo/Foto</label>
                        <input type="file" class="form-control @error('tadika_logo') is-invalid @enderror"
                            name="tadika_logo" accept="image/*">
                        <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                        @error('tadika_logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        
                        @if($tadika->tadika_logo)
                        <div class="mt-2">
                            <strong>Logo Semasa:</strong><br>
                            <img src="{{ asset('storage/' . $tadika->tadika_logo) }}" alt="Tadika logo" 
                                style="max-width: 100px; height: auto; border-radius: 5px;">
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Owner Information Section -->
                <h6 class="fw-bold text-uppercase text-secondary mb-3 small border-bottom pb-2 mt-4">Maklumat Akaun Pemilik</h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Pemilik *</label>
                        <input type="text" class="form-control @error('owner_name') is-invalid @enderror"
                            name="owner_name" value="{{ old('owner_name', $tadika->tadika_owner) }}" required>
                        @error('owner_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">E-mel Pemilik *</label>
                        <input type="email" class="form-control @error('owner_email') is-invalid @enderror"
                            name="owner_email" value="{{ old('owner_email', $tadika->owner ? $tadika->owner->user_email : '') }}" required>
                        @error('owner_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kata Laluan Baru (Kosongkan untuk kekalkan semasa)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" minlength="8">
                        <small class="text-muted">Minimum 8 aksara</small>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sahkan Kata Laluan</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" minlength="8">
                        @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i> Kemaskini Tadika
                    </button>
                    <a href="{{ route('tadika.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
