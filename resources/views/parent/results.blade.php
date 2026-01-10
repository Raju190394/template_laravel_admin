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
                            <li class="breadcrumb-item"><a href="{{ route('parent.student.view', $student->id) }}">{{ $student->name }}</a></li>
                            <li class="breadcrumb-item active">Results</li>
                        </ol>
                    </nav>
                    <h4 class="mb-0">Academic Performance</h4>
                </div>
            </div>
        </div>
    </div>

    @forelse($marks as $examName => $examMarks)
        <div class="bg-white rounded p-4 shadow-sm mb-4">
            <h5 class="mb-3 text-primary border-bottom pb-2">{{ $examName }}</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Subject</th>
                            <th>Full Marks</th>
                            <th>Min Marks</th>
                            <th>Marks Obtained</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($examMarks as $mark)
                            <tr>
                                <td class="text-start">{{ $mark->examSchedule->course->name }}</td>
                                <td>{{ $mark->examSchedule->full_marks }}</td>
                                <td>{{ $mark->examSchedule->min_marks }}</td>
                                <td class="fw-bold fs-5 {{ $mark->marks_obtained < $mark->examSchedule->min_marks ? 'text-danger' : 'text-success' }}">
                                    {{ $mark->is_absent ? 'ABS' : $mark->marks_obtained }}
                                </td>
                                <td>
                                    @if($mark->is_absent)
                                        <span class="badge bg-secondary">Absent</span>
                                    @elseif($mark->marks_obtained >= $mark->examSchedule->min_marks)
                                        <span class="badge bg-success">Pass</span>
                                    @else
                                        <span class="badge bg-danger">Fail</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="bg-white rounded p-4 shadow-sm text-center py-5">
            <p class="text-muted mb-0">No exam results available at the moment.</p>
        </div>
    @endforelse
</div>
@endsection
