@extends('layouts.cms')

@section('title', 'Survey Submissions - Admin')
@section('page-title', 'Survey Management')
@section('header-title', 'Alumni Survey Submissions')
@section('header-subtitle', 'Review and approve alumni registrations')

@section('header-buttons')
<div class="btn-group">
    <a href="{{ route('survey.index', ['status' => 'pending']) }}" 
       class="btn btn-{{ request('status') == 'pending' ? 'primary' : 'outline-primary' }}">
        <i class="fas fa-clock me-2"></i> Pending
        @if($pendingCount = \App\Models\AlumniSurvey::where('status', 'pending')->count())
            <span class="badge bg-danger ms-1">{{ $pendingCount }}</span>
        @endif
    </a>
    <a href="{{ route('survey.index', ['status' => 'approved']) }}" 
       class="btn btn-{{ request('status') == 'approved' ? 'success' : 'outline-success' }}">
        <i class="fas fa-check me-2"></i> Approved
    </a>
    <a href="{{ route('survey.index', ['status' => 'rejected']) }}" 
       class="btn btn-{{ request('status') == 'rejected' ? 'danger' : 'outline-danger' }}">
        <i class="fas fa-times me-2"></i> Rejected
    </a>
    <a href="{{ route('survey.index') }}" class="btn btn-secondary">
        <i class="fas fa-list me-2"></i> All
    </a>
</div>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('survey.index') }}" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control" 
                               value="{{ request('search') }}" placeholder="Search by name, email, or contact...">
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i> Search
                            </button>
                            <a href="{{ route('survey.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-2"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Survey Submissions</h5>
            </div>
            
            <div class="card-body">
                @if($surveys->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Graduation Year</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($surveys as $survey)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $survey->full_name }}</strong>
                                    @if($survey->ic_number)
                                        <br><small class="text-muted">{{ $survey->ic_number }}</small>
                                    @endif
                                </td>
                                <td>{{ $survey->email }}</td>
                                <td>{{ $survey->year_graduated }}</td>
                                <td>{{ $survey->contact_number }}</td>
                                <td>
                                    @if($survey->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($survey->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $survey->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('survey.show', $survey->id) }}" 
                                           class="btn btn-info" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($survey->status == 'pending')
                                            <button type="button" class="btn btn-success" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#approveModal{{ $survey->id }}"
                                                    title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            
                                            <button type="button" class="btn btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rejectModal{{ $survey->id }}"
                                                    title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        
                                        <form action="{{ route('survey.destroy', $survey->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Delete this survey submission?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-dark" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <!-- Approve Modal -->
                                    <div class="modal fade" id="approveModal{{ $survey->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Approve Submission</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('survey.approve', $survey->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to approve this submission?</p>
                                                        <p><strong>{{ $survey->full_name }}</strong> ({{ $survey->email }})</p>
                                                        
                                                        <div class="mb-3">
                                                            <label for="notes{{ $survey->id }}" class="form-label">Notes (Optional)</label>
                                                            <textarea class="form-control" id="notes{{ $survey->id }}" 
                                                                      name="notes" rows="3" 
                                                                      placeholder="Add any notes..."></textarea>
                                                        </div>
                                                        
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            This will create a user account with auto-generated password.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success">Approve & Create Account</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $survey->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject Submission</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('survey.reject', $survey->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to reject this submission?</p>
                                                        <p><strong>{{ $survey->full_name }}</strong> ({{ $survey->email }})</p>
                                                        
                                                        <div class="mb-3">
                                                            <label for="reject_notes{{ $survey->id }}" class="form-label">Reason for Rejection *</label>
                                                            <textarea class="form-control" id="reject_notes{{ $survey->id }}" 
                                                                      name="notes" rows="3" 
                                                                      placeholder="Please provide a reason for rejection..." required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Reject Submission</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $surveys->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Survey Submissions</h4>
                    <p class="text-muted">No survey submissions found with the current filters.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection