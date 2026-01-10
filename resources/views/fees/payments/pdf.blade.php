<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fee Receipt - {{ $feePayment->receipt_no }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            border-bottom: 2px solid #444;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .school-name {
            font-size: 24px;
            font-weight: bold;
            color: #1a73e8;
            margin-bottom: 5px;
        }
        .school-info {
            font-size: 12px;
            color: #666;
        }
        .receipt-title {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #444;
        }
        .details-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .details-table td {
            vertical-align: top;
            padding: 5px 0;
        }
        .fee-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .fee-table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }
        .fee-table td {
            border: 1px solid #dee2e6;
            padding: 10px;
        }
        .total-row {
            font-weight: bold;
            font-size: 16px;
            background-color: #f1f3f4;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .signature-box {
            margin-top: 60px;
            text-align: right;
        }
        .signature-line {
            width: 150px;
            border-top: 1px solid #333;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <table width="100%" class="header">
            <tr>
                <td width="60%">
                    <div class="school-name">{{ $school->school_name ?? 'School Name' }}</div>
                    <div class="school-info">
                        {{ $school->address ?? '' }}, {{ $school->city ?? '' }}<br>
                        Phone: {{ $school->phone ?? '' }} | Email: {{ $school->email ?? '' }}
                    </div>
                </td>
                <td width="40%" class="receipt-title">
                    FEE RECEIPT<br>
                    <span style="font-size: 14px; font-weight: normal; color: #666;">
                        No: {{ $feePayment->receipt_no }}<br>
                        Date: {{ $feePayment->payment_date ? $feePayment->payment_date->format('d M, Y') : 'N/A' }}
                    </span>
                </td>
            </tr>
        </table>

        <table class="details-table">
            <tr>
                <td width="50%">
                    <strong>STUDENT DETAILS:</strong><br>
                    Name: {{ $feePayment->student->name ?? 'N/A' }}<br>
                    Class: {{ $feePayment->student->class->class_name ?? 'N/A' }} 
                    @if(isset($feePayment->student->class) && $feePayment->student->class->section)
                        (Sec: {{ $feePayment->student->class->section }})
                    @endif<br>
                    Email: {{ $feePayment->student->email ?? 'N/A' }}
                </td>
                <td width="50%" style="text-align: right;">
                    <strong>PAYMENT PERIOD:</strong><br>
                    Period: {{ $feePayment->for_month }} {{ $feePayment->for_year }}<br>
                    Method: {{ $feePayment->payment_method }}<br>
                    @if($feePayment->transaction_id)
                        Ref: {{ $feePayment->transaction_id }}
                    @endif
                </td>
            </tr>
        </table>

        <table class="fee-table">
            <thead>
                <tr>
                    <th>Description / Fee Head</th>
                    <th style="text-align: right; width: 120px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $feePayment->feeStructure->fee_head ?? 'Fee Payment' }}</strong><br>
                        <small style="color: #666;">{{ $feePayment->feeStructure->description ?? 'Periodical Fee Payment' }}</small>
                    </td>
                    <td style="text-align: right;">₹{{ number_format($feePayment->amount_paid, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td style="text-align: right;">TOTAL PAID</td>
                    <td style="text-align: right;">₹{{ number_format($feePayment->amount_paid, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <strong>Remarks:</strong> {{ $feePayment->remarks ?? 'N/A' }}
        </div>

        <div class="signature-box">
            <div class="signature-line"></div><br>
            <strong>Authorized Signatory</strong><br>
            <span style="font-size: 10px; color: #999;">Computer Generated Receipt</span>
        </div>

        <div class="footer">
            Thank you for your payment. This is a computer generated receipt and does not require a physical signature.<br>
            @if($school && $school->website)
                {{ $school->website }}
            @endif
        </div>
    </div>
</body>
</html>
