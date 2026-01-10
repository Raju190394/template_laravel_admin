<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mark Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
        }
        .school-name {
            font-size: 22px;
            font-weight: bold;
            color: #1a1a1a;
        }
        .school-details {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        .certificate-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            background: #f0f0f0;
            padding: 10px;
        }
        .student-info {
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
        }
        .info-item {
            font-size: 12px;
        }
        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .marks-table th {
            background: #4a5568;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }
        .marks-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        .marks-table tr:hover {
            background: #f9f9f9;
        }
        .summary-box {
            background: #f8f9fa;
            border: 2px solid #4a5568;
            padding: 15px;
            margin: 20px 0;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 13px;
        }
        .summary-row.total {
            font-weight: bold;
            font-size: 15px;
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 10px;
        }
        .result-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
        .result-pass {
            background: #48bb78;
            color: white;
        }
        .result-fail {
            background: #f56565;
            color: white;
        }
        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            font-size: 11px;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 150px;
            margin: 30px auto 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">{{ $school->school_name ?? 'SCHOOL NAME' }}</div>
        <div class="school-details">
            {{ $school->address ?? 'School Address' }}<br>
            Phone: {{ $school->phone ?? 'N/A' }} | Email: {{ $school->email ?? 'N/A' }}
        </div>
    </div>

    <div class="certificate-title">MARK SHEET / REPORT CARD</div>

    <div class="student-info">
        <div>
            <div class="info-item"><strong>Student Name:</strong> {{ $student->name }}</div>
            <div class="info-item"><strong>Class:</strong> {{ $student->class->class_name ?? 'N/A' }}</div>
            <div class="info-item"><strong>Roll Number:</strong> {{ $student->roll_number ?? 'N/A' }}</div>
        </div>
        <div>
            <div class="info-item"><strong>Exam:</strong> {{ $marks->first()->examSchedule->exam->name ?? 'N/A' }}</div>
            <div class="info-item"><strong>Issue Date:</strong> {{ $issue_date }}</div>
            <div class="info-item"><strong>Father's Name:</strong> {{ $student->father_name ?? 'N/A' }}</div>
        </div>
    </div>

    <table class="marks-table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Subject</th>
                <th>Full Marks</th>
                <th>Pass Marks</th>
                <th>Marks Obtained</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($marks as $index => $mark)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mark->examSchedule->course->course_name ?? 'N/A' }}</td>
                <td>{{ $mark->examSchedule->full_marks }}</td>
                <td>{{ $mark->examSchedule->pass_marks }}</td>
                <td><strong>{{ $mark->is_absent ? 'AB' : $mark->marks_obtained }}</strong></td>
                <td>
                    @if($mark->is_absent)
                        <span style="color: #f56565;">Absent</span>
                    @elseif($mark->marks_obtained >= $mark->examSchedule->pass_marks)
                        <span style="color: #48bb78;">Pass</span>
                    @else
                        <span style="color: #f56565;">Fail</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <div class="summary-row">
            <span>Total Marks:</span>
            <span><strong>{{ $total_marks }}</strong></span>
        </div>
        <div class="summary-row">
            <span>Marks Obtained:</span>
            <span><strong>{{ $obtained_marks }}</strong></span>
        </div>
        <div class="summary-row">
            <span>Percentage:</span>
            <span><strong>{{ $percentage }}%</strong></span>
        </div>
        <div class="summary-row">
            <span>Grade:</span>
            <span><strong>{{ $grade }}</strong></span>
        </div>
        <div class="summary-row total">
            <span>Result:</span>
            <span class="result-badge {{ $result == 'PASS' ? 'result-pass' : 'result-fail' }}">
                {{ $result }}
            </span>
        </div>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Class Teacher</div>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Exam Controller</div>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Principal</div>
        </div>
    </div>

    <div class="footer">
        This is a computer-generated mark sheet. For any discrepancies, please contact the school office.
    </div>
</body>
</html>
