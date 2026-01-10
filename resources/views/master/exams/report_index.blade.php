@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-white rounded h-100 p-4">
        <h6 class="mb-4">Generate Exam Report</h6>
        <form action="{{ route('exams.reports.generate') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">Select Exam</label>
                    <select class="form-select" name="exam_id" required>
                        <option value="">Select Exam</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Select Class</label>
                    <select class="form-select" name="class_id" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->class_name }} {{ $class->section }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Generate</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
