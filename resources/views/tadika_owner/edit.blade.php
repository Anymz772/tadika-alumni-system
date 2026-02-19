@extends('layouts.cms')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Tadika Profile</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">Please fix the errors below.</div>
                    @endif

                    <form method="POST" action="{{ route('tadika.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tadika Name</label>
                                <input type="text" name="tadika_name" class="form-control @error('tadika_name') is-invalid @enderror"
                                    value="{{ old('tadika_name', $tadika->tadika_name ?? '') }}" required>
                                @error('tadika_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Registration Number</label>
                                <input type="text" name="tadika_reg_no" class="form-control @error('tadika_reg_no') is-invalid @enderror"
                                    value="{{ old('tadika_reg_no', $tadika->tadika_reg_no ?? '') }}" required>
                                @error('tadika_reg_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">District</label>
                                <input type="text" name="tadika_district" class="form-control @error('tadika_district') is-invalid @enderror"
                                    value="{{ old('tadika_district', $tadika->tadika_district ?? '') }}" required>
                                @error('tadika_district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="tadika_state" class="form-control @error('tadika_state') is-invalid @enderror"
                                    value="{{ old('tadika_state', $tadika->tadika_state ?? '') }}" required>
                                @error('tadika_state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="tadika_address" class="form-control @error('tadika_address') is-invalid @enderror" rows="3">{{ old('tadika_address', $tadika->tadika_address ?? '') }}</textarea>
                            @error('tadika_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="tadika_phone" class="form-control @error('tadika_phone') is-invalid @enderror"
                                    value="{{ old('tadika_phone', $tadika->tadika_phone ?? '') }}">
                                @error('tadika_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="tadika_email" class="form-control @error('tadika_email') is-invalid @enderror"
                                    value="{{ old('tadika_email', $tadika->tadika_email ?? '') }}">
                                @error('tadika_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Owner / Pengetua Name</label>
                                <input type="text" name="tadika_owner" class="form-control @error('tadika_owner') is-invalid @enderror"
                                    value="{{ old('tadika_owner', $tadika->tadika_owner ?? '') }}">
                                @error('tadika_owner')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Location (URL or details)</label>
                                <input type="text" name="tadika_location" class="form-control @error('tadika_location') is-invalid @enderror"
                                    value="{{ old('tadika_location', $tadika->tadika_location ?? '') }}">
                                @error('tadika_location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tadika Picture / Logo</label>
                            <input type="file" name="tadika_logo" class="form-control @error('tadika_logo') is-invalid @enderror" accept="image/*">
                            @error('tadika_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if(!empty($tadika?->tadika_logo))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $tadika->tadika_logo) }}" alt="Tadika Logo" style="max-height: 120px;">
                                </div>
                            @endif
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-tadika-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection