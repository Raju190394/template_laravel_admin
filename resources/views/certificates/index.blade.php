@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-2 px-2">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-white rounded p-4 border shadow-sm">
                <h5 class="mb-4 fw-bold"><i class="fa fa-certificate me-2 text-primary"></i>Certificate & ID Card Generation</h5>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Certificate Type Selection -->
                <div class="row mb-4">
                    <div class="col-12">
                        <ul class="nav nav-pills mb-3" id="certificateTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="id-card-tab" data-bs-toggle="pill" data-bs-target="#id-card" type="button">
                                    <i class="fa fa-id-card me-2"></i>ID Card
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="transfer-tab" data-bs-toggle="pill" data-bs-target="#transfer" type="button">
                                    <i class="fa fa-exchange-alt me-2"></i>Transfer Certificate
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="bonafide-tab" data-bs-toggle="pill" data-bs-target="#bonafide" type="button">
                                    <i class="fa fa-file-alt me-2"></i>Bonafide Certificate
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="character-tab" data-bs-toggle="pill" data-bs-target="#character" type="button">
                                    <i class="fa fa-award me-2"></i>Character Certificate
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="marksheet-tab" data-bs-toggle="pill" data-bs-target="#marksheet" type="button">
                                    <i class="fa fa-graduation-cap me-2"></i>Mark Sheet
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="certificateTabContent">
                    <!-- ID Card Tab -->
                    <div class="tab-pane fade show active" id="id-card" role="tabpanel">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Generate Student ID Card</h6>
                                <form action="{{ route('certificates.bulk-generate') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="certificate_type" value="id_card">
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Select Students</label>
                                        <select name="student_ids[]" class="form-select" multiple size="10" required>
                                            @foreach($students as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->class->class_name ?? 'N/A' }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Hold Ctrl/Cmd to select multiple students</small>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-download me-2"></i>Generate ID Cards
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="selectAllStudents(this)">
                                            <i class="fa fa-check-double me-2"></i>Select All
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Transfer Certificate Tab -->
                    <div class="tab-pane fade" id="transfer" role="tabpanel">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Generate Transfer Certificate</h6>
                                <form action="{{ route('certificates.transfer', 0) }}" method="POST" id="transferForm">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Select Student</label>
                                            <select name="student_id" class="form-select" required onchange="updateTransferAction(this.value)">
                                                <option value="">-- Select Student --</option>
                                                @foreach($students as $student)
                                                <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->class->class_name ?? 'N/A' }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Last Attendance Date</label>
                                            <input type="date" name="last_attendance_date" class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Reason for Leaving</label>
                                            <input type="text" name="reason" class="form-control" placeholder="e.g., Parent's transfer" value="On request of parents">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Conduct</label>
                                            <select name="conduct" class="form-select">
                                                <option value="Excellent">Excellent</option>
                                                <option value="Good" selected>Good</option>
                                                <option value="Satisfactory">Satisfactory</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-download me-2"></i>Generate Transfer Certificate
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Bonafide Certificate Tab -->
                    <div class="tab-pane fade" id="bonafide" role="tabpanel">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Generate Bonafide Certificate</h6>
                                <form action="{{ route('certificates.bonafide', 0) }}" method="POST" id="bonafideForm">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Select Student</label>
                                            <select name="student_id" class="form-select" required onchange="updateBonafideAction(this.value)">
                                                <option value="">-- Select Student --</option>
                                                @foreach($students as $student)
                                                <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->class->class_name ?? 'N/A' }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Purpose</label>
                                            <input type="text" name="purpose" class="form-control" placeholder="e.g., Bank account opening" value="For general purposes">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-download me-2"></i>Generate Bonafide Certificate
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Character Certificate Tab -->
                    <div class="tab-pane fade" id="character" role="tabpanel">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Generate Character Certificate</h6>
                                <form action="{{ route('certificates.character', 0) }}" method="POST" id="characterForm">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Select Student</label>
                                            <select name="student_id" class="form-select" required onchange="updateCharacterAction(this.value)">
                                                <option value="">-- Select Student --</option>
                                                @foreach($students as $student)
                                                <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->class->class_name ?? 'N/A' }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Character Remarks</label>
                                            <textarea name="character_remarks" class="form-control" rows="3" placeholder="Character description">Good moral character and conduct</textarea>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-download me-2"></i>Generate Character Certificate
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mark Sheet Tab -->
                    <div class="tab-pane fade" id="marksheet" role="tabpanel">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Generate Mark Sheet / Report Card</h6>
                                <form action="{{ route('certificates.marksheet', ['student' => 0, 'exam' => 0]) }}" method="GET" id="marksheetForm">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Select Student</label>
                                            <select name="student_id" class="form-select" required onchange="updateMarksheetStudent(this.value)">
                                                <option value="">-- Select Student --</option>
                                                @foreach($students as $student)
                                                <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->class->class_name ?? 'N/A' }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Select Exam</label>
                                            <select name="exam_id" class="form-select" required onchange="updateMarksheetExam(this.value)">
                                                <option value="">-- Select Exam --</option>
                                                @foreach($exams as $exam)
                                                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-download me-2"></i>Generate Mark Sheet
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function selectAllStudents(btn) {
    const select = btn.closest('form').querySelector('select[multiple]');
    for (let i = 0; i < select.options.length; i++) {
        select.options[i].selected = true;
    }
}

function updateTransferAction(studentId) {
    const form = document.getElementById('transferForm');
    form.action = `/certificates/transfer/${studentId}`;
}

function updateBonafideAction(studentId) {
    const form = document.getElementById('bonafideForm');
    form.action = `/certificates/bonafide/${studentId}`;
}

function updateCharacterAction(studentId) {
    const form = document.getElementById('characterForm');
    form.action = `/certificates/character/${studentId}`;
}

let selectedStudent = 0;
let selectedExam = 0;

function updateMarksheetStudent(studentId) {
    selectedStudent = studentId;
    updateMarksheetAction();
}

function updateMarksheetExam(examId) {
    selectedExam = examId;
    updateMarksheetAction();
}

function updateMarksheetAction() {
    const form = document.getElementById('marksheetForm');
    form.action = `/certificates/marksheet/${selectedStudent}/${selectedExam}`;
}
</script>
@endpush
@endsection
