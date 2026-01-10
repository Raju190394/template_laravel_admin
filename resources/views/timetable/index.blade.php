@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        
        <!-- Selection & Add Form -->
        <div class="col-12">
            <div class="bg-white rounded h-100 p-4">
                <div class="d-flex justify-content-between mb-4 ignore-print">
                    <h6 class="mb-0">Class Routine</h6>
                    <div class="d-flex">
                        <button onclick="window.print()" class="btn btn-secondary me-2">Print</button>
                        <form action="{{ route('timetable.index') }}" method="GET" class="d-flex">
                            <select class="form-select me-2" name="class_id" onchange="this.form.submit()">
                                <option value="">Select Class</option>
                                @foreach($classes as $c)
                                    <option value="{{ $c->id }}" {{ $selected_class_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->class_name }} {{ $c->section }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                @if($class)
                    <!-- Add Entry Form (Collapsible) -->
                    <button class="btn btn-sm btn-outline-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#addRoutineForm">
                        + Add Period
                    </button>
                    <div class="collapse mb-4 {{ $errors->any() ? 'show' : '' }}" id="addRoutineForm">
                        <div class="card card-body">
                            <form action="{{ route('timetable.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="class_id" value="{{ $class->id }}">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <select class="form-select" name="day" required>
                                            <option value="">Day</option>
                                            @foreach($days as $day)
                                                <option value="{{ $day }}">{{ $day }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" name="course_id" required>
                                            <option value="">Subject</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" name="staff_id">
                                            <option value="">Teacher (Optional)</option>
                                            @foreach($staffs as $staff)
                                                <option value="{{ $staff->id }}">{{ $staff->first_name }} {{ $staff->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="room_no" placeholder="Room No">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small">Start Time</label>
                                        <input type="time" class="form-control" name="start_time" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small">End Time</label>
                                        <input type="time" class="form-control" name="end_time" required>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Timetable Display -->
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr class="bg-light">
                                    <th style="width: 15rem;">Day</th>
                                    <th>Periods</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($days as $day)
                                    <tr>
                                        <td class="fw-bold bg-light">{{ $day }}</td>
                                        <td>
                                            @if(isset($timetables[$day]))
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($timetables[$day] as $tt)
                                                        <div class="card p-2 shadow-sm" style="min-width: 200px; border-left: 4px solid var(--primary);">
                                                            <strong>{{ $tt->course->name }}</strong><br>
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($tt->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($tt->end_time)->format('h:i A') }}</small><br>
                                                            @if($tt->staff) <small class="text-primary"><i class="fa fa-user me-1"></i>{{ $tt->staff->first_name }}</small> @endif
                                                            @if($tt->room_no) <br><small class="text-secondary">Room: {{ $tt->room_no }}</small> @endif
                                                            
                                                            <form action="{{ route('timetable.destroy', $tt->id) }}" method="POST" class="mt-1">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="btn btn-xs btn-link text-danger p-0" onclick="return confirm('Remove?')">Remove</button>
                                                            </form>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted text-small">- No Classes -</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">Please select a class to view routine.</div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .navbar, .ignore-print, .footer, .btn, form {
            display: none !important;
        }
        .content {
            margin: 0 !important;
            width: 100% !important;
        }
        .container-fluid {
            padding: 0 !important;
        }
        .card {
            border: 1px solid #ddd !important; 
            break-inside: avoid;
        }
    }
</style>
@endsection
