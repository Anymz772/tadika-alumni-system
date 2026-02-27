@extends('layouts.cms')

@section('title', 'Send Message')
@section('page-title', isset($alumni) ? 'Message ' . $alumni->alumni_name : 'Message Alumni')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="mb-1">
                    @if(isset($alumni))
                        Send message to {{ $alumni->alumni_name }}
                    @else
                        Send message to <strong>all alumni</strong>
                    @endif
                </h2>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('tadika.alumni') }}" class="btn btn-outline-secondary">
                    Back to List
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="alert alert-info">
                    This message will be delivered inside the application inbox, not by email.
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ isset($alumni) ? route('tadika.alumni.message', $alumni->alumni_id) : route('tadika.alumni.message_all') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
