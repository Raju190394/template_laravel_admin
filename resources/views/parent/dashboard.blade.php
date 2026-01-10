@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="bg-white rounded p-4 border-start border-primary border-5">
                <h4 class="mb-0 text-primary">Welcome, {{ Auth::user()->name }}!</h4>
                <p class="text-muted mb-0">Parent Portal Dashboard</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- My Children -->
        <div class="col-sm-12 col-md-8">
            <h6 class="mb-3">My Children</h6>
            <div class="row g-4">
                @forelse($students as $student)
                    <div class="col-md-6">
                        <div class="bg-white rounded p-4 h-100 shadow-sm hover-shadow transition">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="fa fa-user-graduate fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $student->name }}</h5>
                                    <span class="badge bg-secondary">{{ $student->class->class_name }} {{ $student->class->section }}</span>
                                </div>
                            </div>
                            <div class="list-group list-group-flush mb-3">
                                <div class="list-group-item bg-transparent px-0 border-0 py-1 small">
                                    <span class="text-muted">Student ID:</span> #{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}
                                </div>
                                <div class="list-group-item bg-transparent px-0 border-0 py-1 small">
                                    <span class="text-muted">Roll No:</span> {{ $student->roll_no ?? 'N/A' }}
                                </div>
                            </div>
                            <a href="{{ route('parent.student.view', $student->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                View Full Dashboard <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">No students linked to your account.</div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- System Notices -->
        <div class="col-sm-12 col-md-4">
            <h6 class="mb-3">Recent Notices</h6>
            <div class="bg-white rounded p-4 shadow-sm h-100">
                @forelse($notices as $notice)
                    <div class="mb-3 pb-3 border-bottom last-no-border">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <strong class="text-dark">{{ $notice->title }}</strong>
                            <small class="text-muted">{{ $notice->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="small text-muted mb-0">{{ Str::limit($notice->content, 100) }}</p>
                    </div>
                @empty
                    <p class="text-muted text-center py-4">No recent notices.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.transition {
    transition: all 0.3s ease;
}
.last-no-border:last-child {
    border-bottom: 0 !important;
}
</style>
@endsection
