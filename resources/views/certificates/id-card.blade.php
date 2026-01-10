<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student ID Card</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 10px;
        }
        .id-card {
            width: 85.6mm;
            height: 54mm;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px;
            text-align: center;
        }
        .school-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .id-text {
            font-size: 10px;
            letter-spacing: 2px;
        }
        .content {
            display: flex;
            padding: 10px;
        }
        .photo-section {
            width: 80px;
            text-align: center;
        }
        .photo {
            width: 70px;
            height: 70px;
            border: 2px solid #667eea;
            border-radius: 4px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #999;
        }
        .details {
            flex: 1;
            padding-left: 10px;
        }
        .detail-row {
            margin-bottom: 4px;
            font-size: 10px;
        }
        .label {
            font-weight: bold;
            color: #667eea;
            display: inline-block;
            width: 60px;
        }
        .value {
            color: #333;
        }
        .footer {
            background: #f8f9fa;
            padding: 5px 10px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 2px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="header">
            <div class="school-name">{{ $school->school_name ?? 'SCHOOL NAME' }}</div>
            <div class="id-text">STUDENT ID CARD</div>
        </div>
        
        <div class="content">
            <div class="photo-section">
                @if($student->photo)
                    <img src="{{ public_path('storage/' . $student->photo) }}" alt="Photo" class="photo">
                @else
                    <div class="photo">PHOTO</div>
                @endif
            </div>
            
            <div class="details">
                <div class="detail-row">
                    <span class="label">Name:</span>
                    <span class="value">{{ $student->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Class:</span>
                    <span class="value">{{ $student->class->class_name ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Roll No:</span>
                    <span class="value">{{ $student->roll_number ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">DOB:</span>
                    <span class="value">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d-m-Y') : 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Session:</span>
                    <span class="value">{{ $academic_year }}</span>
                </div>
            </div>
        </div>
        
        <div class="footer">
            Valid for Academic Year {{ $academic_year }} | {{ $school->phone ?? 'Contact: N/A' }}
        </div>
    </div>
</body>
</html>
