@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-white rounded h-100 p-4">
                <h6 class="mb-4">Student Promotion</h6>
                
                <!-- Step 1: Select Source Class -->
                <form action="{{ route('master.promotion.index') }}" method="GET" class="row g-3 mb-4 border-bottom pb-4">
                    <div class="col-md-4">
                        <label for="class_id" class="form-label">Current Class</label>
                        <select class="form-select" id="class_id" name="class_id" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }} {{ $class->section ? '('.$class->section.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="session_id" class="form-label">Current Session</label>
                        <select class="form-select" id="session_id" name="session_id" required>
                            <option value="">Select Session</option>
                            @foreach($sessions as $session)
                                <option value="{{ $session->id }}" {{ (request('session_id') == $session->id) ? 'selected' : (($currentSession && $session->id == $currentSession->id && !request('session_id')) ? 'selected' : '') }}>
                                    {{ $session->name }} {{ $session->is_current ? '(Current)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Fetch Students</button>
                    </div>
                </form>

                <!-- Step 2: List Students & Promote -->
                @if(request('class_id') && request('session_id'))
                    @if(count($students) > 0)
                        <form action="{{ route('master.promotion.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="current_class_id" value="{{ request('class_id') }}">
                            <input type="hidden" name="current_session_id" value="{{ request('session_id') }}">

                            <div class="row g-3 mb-4 bg-light p-3 rounded">
                                <div class="col-md-6">
                                    <label for="target_class_id" class="form-label fw-bold">Promote To Class</label>
                                    <select class="form-select border-primary" id="target_class_id" name="target_class_id" required>
                                        <option value="">Select Target Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ (request('class_id') + 1 == $class->id) ? 'selected' : '' }}>
                                                {{ $class->class_name }} {{ $class->section ? '('.$class->section.')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="target_session_id" class="form-label fw-bold">Target Session</label>
                                    <select class="form-select border-primary" id="target_session_id" name="target_session_id" required>
                                        <option value="">Select Target Session</option>
                                        @foreach($sessions as $session)
                                            <option value="{{ $session->id }}">
                                                {{ $session->name }} {{ $session->is_current ? '(Current)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col"><input type="checkbox" id="select-all" class="form-check-input"></th>
                                            <th scope="col">Student Name</th>
                                            <th scope="col">Roll Number</th>
                                            <th scope="col">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="form-check-input student-checkbox" checked>
                                                </td>
                                                <td>{{ $student->name }}</td>
                                                <td>N/A</td>
                                                <td>{{ $student->email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button type="submit" class="btn btn-success mt-3" onclick="return confirm('Note: This will move selected students to the new class and create session records. Continue?')">
                                <i class="fa fa-arrow-up me-2"></i>Promote Selected Students
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info">No students found in the selected class.</div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('select-all')?.addEventListener('change', function() {
        document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection
