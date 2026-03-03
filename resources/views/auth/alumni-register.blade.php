@extends('layouts.public')

@section('title', 'Pendaftaran Alumni - Sistem Alumni Tadika')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="survey-container">
                <div class="text-center mb-5">
                    <h2 class="mb-3"><i class="fas fa-user-plus me-2"></i>Pendaftaran Alumni</h2>
                    <p class="text-muted">Cipta akaun anda untuk menyertai Rangkaian Alumni Tadika</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> Sila betulkan ralat di bawah.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('alumni.register') }}">
                    @csrf

                    <div class="form-section">
                        <h5><i class="fas fa-user me-2"></i>Maklumat Akaun</h5>

                        <div class="alert alert-info">
                            <small><i class="fas fa-info-circle me-2"></i>Hanya maklumat asas diperlukan. Maklumat tambahan boleh dilengkapkan selepas pendaftaran melalui halaman profil anda.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="user_name" class="form-label required">Nama Pengguna</label>
                                <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                                    id="user_name" name="user_name" value="{{ old('user_name') }}" required>
                                @error('user_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="alumni_name" class="form-label required">Nama Penuh</label>
                                <input type="text" class="form-control @error('alumni_name') is-invalid @enderror"
                                    id="alumni_name" name="alumni_name" value="{{ old('alumni_name') }}" required>
                                @error('alumni_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="user_email" class="form-label required">Alamat Emel</label>
                                <input type="email" class="form-control @error('user_email') is-invalid @enderror"
                                    id="user_email" name="user_email" value="{{ old('user_email') }}" required>
                                <small class="form-text text-muted">Alamat emel akan digunakan untuk log masuk</small>
                                @error('user_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label required">Kata Laluan</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label required">Sahkan Kata Laluan</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5><i class="fas fa-info-circle me-2"></i>Maklumat Tambahan (Pilihan)</h5>

                        @if (isset($prefilledTadika))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-magic me-2"></i> Maklumat untuk
                                <strong>{{ $prefilledTadika->tadika_name }}</strong> telah diisi secara automatik berdasarkan pautan jemputan anda!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="alumni_ic" class="form-label">No. IC</label>
                                <input type="text" class="form-control @error('alumni_ic') is-invalid @enderror"
                                    id="alumni_ic" name="alumni_ic" value="{{ old('alumni_ic') }}" maxlength="14">
                                <small class="form-text text-muted">Format: YYMMDD-SS-XXXX</small>
                                @error('alumni_ic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jantina</label>
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                    name="gender">
                                    <option value="">Pilih Jantina</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Lelaki</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="age" class="form-label">Umur</label>
                                <input type="number" class="form-control @error('age') is-invalid @enderror"
                                    id="age" name="age" value="{{ old('age') }}" min="1"
                                    max="100">
                                @error('age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="alumni_state" class="form-label">Negeri</label>
                                <input type="text" class="form-control @error('alumni_state') is-invalid @enderror"
                                    id="alumni_state" name="alumni_state" list="alumni-state-list"
                                    value="{{ old('alumni_state', $prefilledTadika->tadika_state ?? '') }}">
                                @error('alumni_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="alumni_district" class="form-label">Daerah</label>
                                <input type="text" class="form-control @error('alumni_district') is-invalid @enderror"
                                    id="alumni_district" name="alumni_district" list="alumni-district-list"
                                    value="{{ old('alumni_district', $prefilledTadika->tadika_district ?? '') }}">
                                @error('alumni_district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="alumni_postcode" class="form-label">Poskod</label>
                                <input type="text" class="form-control @error('alumni_postcode') is-invalid @enderror"
                                    id="alumni_postcode" name="alumni_postcode" list="alumni-postcode-list"
                                    value="{{ old('alumni_postcode', $prefilledTadika->tadika_postcode ?? '') }}">
                                @error('alumni_postcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <datalist id="alumni-state-list">
                            @foreach ($states as $state)
                                <option value="{{ $state }}"></option>
                            @endforeach
                        </datalist>
                        <datalist id="alumni-district-list">
                            @foreach ($districts as $district)
                                <option value="{{ $district }}"></option>
                            @endforeach
                        </datalist>
                        <datalist id="alumni-postcode-list">
                            @foreach ($postcodes as $postcode)
                                <option value="{{ $postcode }}"></option>
                            @endforeach
                        </datalist>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="tadika_name" class="form-label">Nama Tadika</label>
                                <input type="text" class="form-control @error('tadika_name') is-invalid @enderror"
                                    id="tadika_name" name="tadika_name" list="tadika-name-list"
                                    value="{{ old('tadika_name', $prefilledTadika->tadika_name ?? '') }}"
                                    placeholder="Cari atau masukkan nama tadika">
                                @error('tadika_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <datalist id="tadika-name-list">
                            @foreach ($tadikaNames as $tadikaName)
                                <option value="{{ $tadikaName }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <div class="form-section">
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Pendaftaran Pantas!</strong> Akaun anda akan dibuat serta-merta. Anda boleh log masuk selepas pendaftaran dan lengkapkan maklumat tambahan di profil anda.
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
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
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .survey-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .form-section h5 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .required::after {
            content: " *";
            color: #e74c3c;
        }

        .conditional-fields {
            transition: all 0.3s ease;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const icNumberInput = document.getElementById('alumni_ic');
            const ageInput = document.getElementById('age');

            // Auto-format IC number input
            if (icNumberInput) {
                icNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^\d]/g, '');

                    if (value.length >= 6) {
                        value = value.substring(0, 6) + '-' + value.substring(6);
                    }
                    if (value.length >= 9) {
                        value = value.substring(0, 9) + '-' + value.substring(9);
                    }
                    if (value.length > 14) {
                        value = value.substring(0, 14);
                    }

                    e.target.value = value;

                    // Auto-calculate age from IC number
                    if (value.length >= 6) {
                        const birthDateStr = value.substring(0, 6);
                        if (birthDateStr.length === 6) {
                            const age = calculateAgeFromIC(birthDateStr);
                            if (age !== null) {
                                ageInput.value = age;
                            }
                        }
                    }
                });
            }

            function calculateAgeFromIC(birthDateStr) {
                const year = parseInt(birthDateStr.substring(0, 2));
                const month = parseInt(birthDateStr.substring(2, 4)) - 1;
                const day = parseInt(birthDateStr.substring(4, 6));

                const fullYear = year >= 50 ? 1900 + year : 2000 + year;

                const birthDate = new Date(fullYear, month, day);
                const today = new Date();

                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                return age > 0 && age < 100 ? age : null;
            }
        });
    </script>
@endpush
