@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="bg-white rounded p-4 d-flex justify-content-between align-items-center shadow-sm">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="{{ route('parent.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $student->name }}</li>
                        </ol>
                    </nav>
                    <h4 class="mb-0">{{ $student->name }}'s Profile</h4>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary px-3 py-2">{{ $student->class->class_name }} - {{ $student->class->section }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Quick Stats -->
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('parent.student.attendance', $student->id) }}" class="text-decoration-none">
                <div class="bg-white rounded p-4 text-center h-100 shadow-sm border-bottom border-success border-4">
                    <i class="fa fa-calendar-check fa-3x text-success mb-3"></i>
                    <h6 class="mb-0">Attendance</h6>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('parent.student.fees', $student->id) }}" class="text-decoration-none">
                <div class="bg-white rounded p-4 text-center h-100 shadow-sm border-bottom border-warning border-4">
                    <i class="fa fa-receipt fa-3x text-warning mb-3"></i>
                    <h6 class="mb-0">Fees History</h6>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('parent.student.results', $student->id) }}" class="text-decoration-none">
                <div class="bg-white rounded p-4 text-center h-100 shadow-sm border-bottom border-danger border-4">
                    <i class="fa fa-poll fa-3x text-danger mb-3"></i>
                    <h6 class="mb-0">Exam Results</h6>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="bg-white rounded p-4 text-center h-100 shadow-sm border-bottom border-primary border-4">
                <i class="fa fa-book fa-3x text-primary mb-3"></i>
                <h6 class="mb-0">Routine / Books</h6>
            </div>
        </div>

        <!-- Attendance Summary -->
        <div class="col-md-6">
            <div class="bg-white rounded p-4 shadow-sm h-100">
                <h6 class="mb-4">Attendance Summary</h6>
                <div class="d-flex justify-content-around text-center py-4">
                    @php 
                        $present = $attendance_summary->where('status', 'Present')->first()->count ?? 0;
                        $absent = $attendance_summary->where('status', 'Absent')->first()->count ?? 0;
                        $late = $attendance_summary->where('status', 'Late')->first()->count ?? 0;
                        $total = $present + $absent + $late;
                        $percent = $total > 0 ? round(($present / $total) * 100) : 0;
                    @endphp
                    <div>
                        <h2 class="text-success mb-0">{{ $present }}</h2>
                        <small class="text-muted">Present</small>
                    </div>
                    <div class="border-start border-end px-4">
                        <h2 class="text-danger mb-0">{{ $absent }}</h2>
                        <small class="text-muted">Absent</small>
                    </div>
                    <div>
                        <h2 class="text-primary mb-0">{{ $percent }}%</h2>
                        <small class="text-muted">Average</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Results -->
        <div class="col-md-6">
            <div class="bg-white rounded p-4 shadow-sm h-100">
                <h6 class="mb-4">Latest Marks</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr class="text-muted small">
                                <th>Subject</th>
                                <th>Exam</th>
                                <th>Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_marks as $mark)
                                <tr>
                                    <td>{{ $mark->examSchedule->course->name }}</td>
                                    <td>{{ $mark->examSchedule->exam->exam_name }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $mark->marks_obtained }}</span>
                                        <small class="text-muted">/ {{ $mark->examSchedule->full_marks }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-4 text-muted">No results found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
