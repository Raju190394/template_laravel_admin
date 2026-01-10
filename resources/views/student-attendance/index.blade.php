@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-white rounded h-100 p-4">
                <h6 class="mb-4">Daily Student Attendance</h6>

                <form action="{{ route('student-attendance.index') }}" method="GET" class="row g-3 mb-4 border-bottom pb-4">
                    <div class="col-md-4">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-select" name="class_id" id="class_id" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }} {{ $class->section }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" id="date" value="{{ request('date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Fetch Student List</button>
                    </div>
                </form>

                @if(request('class_id') && request('date'))
                    @if(count($students) > 0)
                        <form action="{{ route('student-attendance.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                            <input type="hidden" name="date" value="{{ request('date') }}">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-primary">Attendance for {{ request('date') }}</h6>
                                @if($isLocked)
                                    <span class="badge bg-danger"><i class="fa fa-lock me-1"></i> Locked</span>
                                @endif
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                            @php
                                                $currentStatus = $attendanceData[$student->id]->status ?? 'Present';
                                                $currentRemarks = $attendanceData[$student->id]->remarks ?? '';
                                            @endphp
                                            <tr>
                                                <td>{{ $student->name }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        @foreach(['Present', 'Absent', 'Late', 'Half Day', 'Holiday'] as $status)
                                                            <input type="radio" class="btn-check" 
                                                                name="attendance[{{ $student->id }}]" 
                                                                id="status_{{ $student->id }}_{{ $status }}" 
                                                                value="{{ $status }}" 
                                                                {{ $currentStatus == $status ? 'checked' : '' }}
                                                                {{ $isLocked ? 'disabled' : '' }}>
                                                            <label class="btn btn-outline-{{ $status == 'Present' ? 'success' : ($status == 'Absent' ? 'danger' : 'warning') }}" 
                                                                for="status_{{ $student->id }}_{{ $status }}">
                                                                {{ $status }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="remarks[{{ $student->id }}]" 
                                                        value="{{ $currentRemarks }}" placeholder="Optional" {{ $isLocked ? 'disabled' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if(!$isLocked)
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" name="lock_attendance" id="lock_attendance">
                                    <label class="form-check-label text-danger" for="lock_attendance">
                                        Lock Attendance (Cannot be edited after submission)
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Save Attendance</button>
                            @endif
                        </form>
                    @else
                        <div class="alert alert-info">No students found in this class.</div>
                    @endif
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
