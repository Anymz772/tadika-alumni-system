@extends('layouts.cms')

@section('title', 'Survey Details - ' . $survey->full_name)
@section('page-title', 'Survey Details')
@section('header-title', $survey->full_name)

@section('header-buttons')
<div class="btn-group">
    <a href="{{ route('survey.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Back to List
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Submission Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Personal Information</h6>
                        <p><strong>Full Name:</strong> {{ $survey->full_name }}</p>
                        <p><strong>IC Number:</strong> {{ $survey->ic_number ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $survey->email }}</p>
                        <p><strong>Contact Number:</strong> {{ $survey->contact_number }}</p>
                        <p><strong>Year Graduated:</strong> {{ $survey->year_graduated }}</p>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-primary">Professional Information</h6>
                        <p><strong>Current Status:</strong>
                            @if($survey->current_status === 'studying')
                            <span class="badge bg-info"><i class="fas fa-graduation-cap me-1"></i> Studying</span>
                            @elseif($survey->current_status === 'working')
                            <span class="badge bg-success"><i class="fas fa-briefcase me-1"></i> Working</span>
                            @else
                            N/A
                            @endif
                        </p>
                        @if($survey->current_status === 'studying')
                        <p><strong>Institution Name:</strong> {{ $survey->institution_name ?? 'N/A' }}</p>
                        @elseif($survey->current_status === 'working')
                        <p><strong>Company Name:</strong> {{ $survey->company_name ?? 'N/A' }}</p>
                        <p><strong>Job Title:</strong> {{ $survey->job_position ?? 'N/A' }}</p>
                        @endif
                        <p><strong>Address:</strong> {{ $survey->address ?? 'N/A' }}</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-primary">Parents Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Father's Name:</strong> {{ $survey->father_name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Mother's Name:</strong> {{ $survey->mother_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <p><strong>Parent Contact:</strong> {{ $survey->parent_contact ?? 'N/A' }}</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Submission Information</h6>
                        <p><strong>Status:</strong>
                            @if($survey->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                            @elseif($survey->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                            @else
                            <span class="badge bg-danger">Rejected</span>
                            @endif
                        </p>
                        <p><strong>Submitted:</strong> {{ $survey->created_at->format('d M Y, H:i') }}</p>
                        <p><strong>Last Updated:</strong> {{ $survey->updated_at->format('d M Y, H:i') }}</p>
                    </div>

                    @if($survey->admin_notes)
                    <div class="col-md-6">
                        <h6 class="text-primary">Admin Notes</h6>
                        <div class="bg-light p-3 rounded">
                            {{ $survey->admin_notes }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($survey->status == 'pending')
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <!-- Approve Form -->
                    <form action="{{ route('survey.approve', $survey->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success"
                            onclick="return confirm('Approve this submission and create alumni account?')">
                            <i class="fas fa-check me-2"></i> Approve & Create Account
                        </button>
                    </form>

                    <!-- Reject Button (opens modal) -->
                    <button type="button" class="btn btn-danger"
                        data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times me-2"></i> Reject Submission
                    </button>
                </div>

                <!-- Reject Modal -->
                <div class="modal fade" id="rejectModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reject Submission</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('survey.reject', $survey->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Reason for Rejection *</label>
                                        <textarea class="form-control" id="notes" name="notes"
                                            rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                @if($survey->status == 'pending')
                <div class="d-grid gap-2 mb-3">
                    <form action="{{ route('survey.approve', $survey->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mb-2"
                            onclick="return confirm('Approve and create alumni account?')">
                            <i class="fas fa-check me-2"></i> Approve
                        </button>
                    </form>

                    <button type="button" class="btn btn-danger w-100"
                        data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times me-2"></i> Reject
                    </button>
                </div>
                @endif

                <div class="d-grid gap-2">
                    @if(\App\Models\User::where('email', $survey->email)->exists())
                    <a href="mailto:{{ $survey->email }}" class="btn btn-info w-100">
                        <i class="fas fa-envelope me-2"></i> Send Email
                    </a>
                    @endif

                    <form action="{{ route('survey.destroy', $survey->id) }}" method="POST"
                        onsubmit="return confirm('Delete this survey submission?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-trash me-2"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Submission Timeline</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-paper-plane text-primary me-2"></i>
                        <strong>Submitted:</strong> {{ $survey->created_at->diffForHumans() }}
                    </li>
                    <li>
                        <i class="fas fa-sync text-info me-2"></i>
                        <strong>Last Updated:</strong> {{ $survey->updated_at->diffForHumans() }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection