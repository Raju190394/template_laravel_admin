@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-white rounded h-100 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6 class="mb-0">Marks Entry: {{ $exam_schedule->exam->name }}</h6>
                <small class="text-muted">
                    {{ $exam_schedule->class->class_name }} {{ $exam_schedule->class->section }} | 
                    {{ $exam_schedule->course->name }} | 
                    Max Marks: {{ $exam_schedule->full_marks }}
                </small>
            </div>
            <a href="{{ route('exams.schedules.index', $exam_schedule->exam_id) }}" class="btn btn-secondary">Back to Schedule</a>
        </div>

        @if(count($students) > 0)
            <form action="{{ route('exams.marks.store', $exam_schedule->id) }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Roll No (Name)</th>
                                <th>Marks Obtained</th>
                                <th>Is Absent</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                @php
                                    $mark = $existingMarks[$student->id] ?? null;
                                    $val = $mark ? $mark->marks_obtained : '';
                                    $absent = $mark ? $mark->is_absent : false;
                                    $rem = $mark ? $mark->remarks : '';
                                @endphp
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>
                                        <input type="number" step="0.5" class="form-control" 
                                            name="marks[{{ $student->id }}]" 
                                            value="{{ $val }}" 
                                            max="{{ $exam_schedule->full_marks }}" 
                                            {{ $absent ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" 
                                            name="absent[{{ $student->id }}]" 
                                            value="1" 
                                            onchange="toggleMarkInput(this)"
                                            {{ $absent ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="remarks[{{ $student->id }}]" value="{{ $rem }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Save Marks</button>
            </form>
        @else
            <div class="alert alert-info">No students found in this class.</div>
        @endif
    </div>
</div>

<script>
    function toggleMarkInput(checkbox) {
        const row = checkbox.closest('tr');
        const numberInput = row.querySelector('input[type="number"]');
        if (checkbox.checked) {
            numberInput.disabled = true;
            numberInput.value = '';
        } else {
            numberInput.disabled = false;
        }
    }
</script>
@endsection
