@extends('layouts.app')

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
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $tadika->name ?? '') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Registration Number</label>
                                <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror"
                                    value="{{ old('registration_number', $tadika->registration_number ?? '') }}" required>
                                @error('registration_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">District</label>
                                <input type="text" name="district" class="form-control @error('district') is-invalid @enderror"
                                    value="{{ old('district', $tadika->district ?? '') }}" required>
                                @error('district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
                                    value="{{ old('state', $tadika->state ?? '') }}" required>
                                @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $tadika->address ?? '') }}</textarea>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $tadika->phone ?? '') }}">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $tadika->email ?? '') }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Owner / Pengetua Name</label>
                                <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror"
                                    value="{{ old('owner_name', $tadika->owner_name ?? '') }}">
                                @error('owner_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                    value="{{ old('location', $tadika->location ?? '') }}">
                                @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tadika Picture / Logo</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                            @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if(!empty($tadika?->logo))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $tadika->logo) }}" alt="Tadika Logo" style="max-height: 120px;">
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
