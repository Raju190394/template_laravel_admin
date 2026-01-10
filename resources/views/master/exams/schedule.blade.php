@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        
        <!-- Schedule Form -->
        <div class="col-md-4">
            <div class="bg-white rounded h-100 p-4">
                <h6 class="mb-4">Schedule Subject for {{ $exam->name }}</h6>
                <form action="{{ route('exams.schedules.store', $exam->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Class</label>
                        <select class="form-select" name="class_id" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class_name }} {{ $class->section }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subject (Course)</label>
                        <select class="form-select" name="course_id" required>
                            <option value="">Select Subject</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" min="{{ $exam->start_date->format('Y-m-d') }}" max="{{ $exam->end_date->format('Y-m-d') }}" required>
                        <div class="form-text">Between {{ $exam->start_date->format('d M') }} and {{ $exam->end_date->format('d M') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="form-control" name="start_time" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">End Time</label>
                            <input type="time" class="form-control" name="end_time" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Full Marks</label>
                            <input type="number" class="form-control" name="full_marks" value="100" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Pass Marks</label>
                            <input type="number" class="form-control" name="pass_marks" value="40" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Room No (Optional)</label>
                        <input type="text" class="form-control" name="room_no">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Add Schedule</button>
                    <a href="{{ route('master.exams.index') }}" class="btn btn-outline-secondary w-100 mt-2">Back to Exams</a>
                </form>
            </div>
        </div>

        <!-- Schedule List -->
        <div class="col-md-8">
            <div class="bg-white rounded h-100 p-4">
                <h6 class="mb-4">Exam Schedules: {{ $exam->name }}</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Time</th>
                                <th>Marks (Pass)</th>
                                <th>Marks Entry</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->date->format('d M Y') }}</td>
                                    <td>{{ $schedule->class->class_name }} {{ $schedule->class->section }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                                    <td>{{ $schedule->full_marks }} ({{ $schedule->pass_marks }})</td>
                                    <td>
                                        <a href="{{ route('exams.marks.index', $schedule->id) }}" class="btn btn-sm btn-warning">Enter Marks</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No schedules found. Add one from the left.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
