<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bonafide Certificate</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            padding: 40px;
            line-height: 1.8;
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
        }
        .school-details {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .certificate-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin: 30px 0;
            text-decoration: underline;
        }
        .cert-number {
            text-align: right;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .content {
            margin: 40px 0;
            text-align: justify;
            font-size: 14px;
        }
        .student-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .signature-section {
            margin-top: 80px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin: 40px 0 5px auto;
        }
        .seal-box {
            position: absolute;
            bottom: 100px;
            left: 80px;
            text-align: center;
            border: 2px solid #333;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
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

    <div class="cert-number">
        <strong>Certificate No:</strong> {{ $certificate_number }}<br>
        <strong>Date:</strong> {{ $issue_date }}
    </div>

    <div class="certificate-title">BONAFIDE CERTIFICATE</div>

    <div class="content">
        <p>This is to certify that <span class="student-name">{{ strtoupper($student->name) }}</span>, 
        son/daughter of <strong>{{ $student->father_name ?? 'N/A' }}</strong>, 
        is a bonafide student of this institution, studying in 
        <strong>{{ $student->class->class_name ?? 'N/A' }}</strong> 
        during the academic year <strong>{{ date('Y') }}-{{ date('Y') + 1 }}</strong>.</p>

        <p>His/Her date of birth as per the school records is 
        <strong>{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d F Y') : 'N/A' }}</strong>.</p>

        <p>This certificate is issued for the purpose of <strong>{{ $purpose }}</strong>.</p>

        <p>We wish him/her all success in life.</p>
    </div>

    <div class="seal-box">
        SCHOOL<br>SEAL
    </div>

    <div class="signature-section">
        <div class="signature-line"></div>
        <div><strong>Principal</strong></div>
        <div style="font-size: 12px;">{{ $school->school_name ?? 'School Name' }}</div>
    </div>
</body>
</html>
