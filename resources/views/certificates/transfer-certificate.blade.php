<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transfer Certificate</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            padding: 40px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px double #333;
            padding-bottom: 20px;
        }
        .school-name {
            font-size: 24px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 5px;
        }
        .school-details {
            font-size: 12px;
            color: #666;
        }
        .certificate-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            text-decoration: underline;
        }
        .tc-number {
            text-align: right;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .content {
            margin: 30px 0;
            text-align: justify;
        }
        .detail-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .detail-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .detail-table td:first-child {
            width: 40%;
            font-weight: bold;
        }
        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin: 40px auto 5px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
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

    <div class="tc-number">
        <strong>TC No:</strong> {{ $tc_number }}<br>
        <strong>Date:</strong> {{ $issue_date }}
    </div>

    <div class="certificate-title">TRANSFER CERTIFICATE</div>

    <div class="content">
        <p>This is to certify that <strong>{{ $student->name }}</strong>, 
        son/daughter of <strong>{{ $student->father_name ?? 'N/A' }}</strong>, 
        was a bonafide student of this institution.</p>
    </div>

    <table class="detail-table">
        <tr>
            <td>Admission Number</td>
            <td>{{ $student->admission_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Date of Birth (in words)</td>
            <td>{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d F Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Class in which studying</td>
            <td>{{ $student->class->class_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Date of Admission</td>
            <td>{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d-m-Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <td>Date of Leaving</td>
            <td>{{ $last_attendance_date }}</td>
        </tr>
        <tr>
            <td>Reason for Leaving</td>
            <td>{{ $reason }}</td>
        </tr>
        <tr>
            <td>Conduct & Character</td>
            <td>{{ $conduct }}</td>
        </tr>
        <tr>
            <td>Remarks</td>
            <td>{{ $remarks ?? 'NIL' }}</td>
        </tr>
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Class Teacher</div>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Principal</div>
        </div>
    </div>

    <div class="footer">
        This is a computer-generated certificate. Official seal and signature to be affixed on the original copy.
    </div>
</body>
</html>
