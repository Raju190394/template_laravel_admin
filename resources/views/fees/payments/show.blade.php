@extends('layouts.admin')

@section('content')
<style>
    @media print {
        /* Hide everything by default */
        body * {
            visibility: hidden;
        }
        /* Show only the receipt container and its children */
        .receipt-container, .receipt-container * {
            visibility: visible;
        }
        /* Position the receipt at the top left of the print page */
        .receipt-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100% !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        /* Hide UI elements specifically */
        .sidebar, .navbar, .btn, .footer, .no-print, .breadcrumb {
            display: none !important;
        }
        /* Reset content area for print */
        .content, .container-xxl {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        
        /* Force background colors to print */
        .bg-light {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
        }
        .table-light {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
        }
    }
    .receipt-container {
        background: white;
        padding: 40px;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        max-width: 850px;
        margin: 20px auto;
    }
    .receipt-header {
        border-bottom: 2px solid #f0f2f5;
        margin-bottom: 25px;
        padding-bottom: 20px;
    }
    .school-logo {
        max-width: 90px;
        height: auto;
    }
</style>

<div class="container-xxl pt-2 px-2">
    <div class="row g-4 no-print mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('fees.payments.index') }}">Fee Payments</a></li>
                        <li class="breadcrumb-item active">View Receipt</li>
                    </ol>
                </nav>
                <div>
                    <a href="{{ route('fees.payments.pdf', $feePayment->id) }}" class="btn btn-outline-danger me-2">
                        <i class="fa fa-file-pdf me-1"></i>Download PDF
                    </a>
                    <button onclick="window.print()" class="btn btn-primary me-2">
                        <i class="fa fa-print me-1"></i>Print Receipt
                    </button>
                    <a href="{{ route('fees.payments.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="receipt-container shadow-sm mb-4">
        <div class="receipt-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                @if($school && $school->logo)
                    <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="school-logo me-3">
                @else
                    <div class="bg-primary text-white rounded p-3 me-3">
                        <i class="fa fa-school fa-2x"></i>
                    </div>
                @endif
                <div>
                    <h3 class="mb-0 fw-bold">{{ $school->school_name ?? 'School Name Not Set' }}</h3>
                    <p class="text-muted mb-0 small">
                        {{ $school->address ?? '' }}, {{ $school->city ?? '' }}<br>
                        Phone: {{ $school->phone ?? '' }} | Email: {{ $school->email ?? '' }}
                    </p>
                </div>
            </div>
            <div class="text-end">
                <h4 class="text-primary mb-0">FEE RECEIPT</h4>
                <p class="mb-0 fw-bold">No: {{ $feePayment->receipt_no }}</p>
                <p class="mb-0 small text-muted">Date: {{ $feePayment->payment_date ? $feePayment->payment_date->format('d M, Y') : 'N/A' }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <h6 class="text-muted small text-uppercase mb-2">Student Details</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td width="30%" class="ps-0">Name:</td>
                        <th class="ps-0">{{ $feePayment->student->name ?? 'N/A' }}</th>
                    </tr>
                    <tr>
                        <td class="ps-0">Class:</td>
                        <th class="ps-0">{{ $feePayment->student->class->class_name ?? 'N/A' }} 
                            @if(isset($feePayment->student->class) && $feePayment->student->class->section)
                                (Sec: {{ $feePayment->student->class->section }})
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <td class="ps-0">Email:</td>
                        <td class="ps-0">{{ $feePayment->student->email ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6 text-end">
                <h6 class="text-muted small text-uppercase mb-2">Payment Period</h6>
                <p class="mb-0 fw-bold fs-5 text-dark">
                    {{ $feePayment->for_month }} {{ $feePayment->for_year }}
                </p>
                <p class="mb-0 small text-muted">Payment: {{ $feePayment->payment_method }}</p>
                @if($feePayment->transaction_id)
                    <p class="mb-0 small text-muted">Ref: {{ $feePayment->transaction_id }}</p>
                @endif
            </div>
        </div>

        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>Description / Fee Head</th>
                        <th class="text-end" width="20%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>{{ $feePayment->feeStructure->fee_head ?? 'Deleted Fee Head' }}</strong><br>
                            <small class="text-muted">{{ $feePayment->feeStructure->description ?? 'Periodical Fee Payment' }}</small>
                        </td>
                        <td class="text-end fw-bold">₹{{ number_format($feePayment->amount_paid, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-end fs-5">TOTAL PAID</th>
                        <th class="text-end fs-5 text-primary">₹{{ number_format($feePayment->amount_paid, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row mt-5 pt-4">
            <div class="col-6 pt-4">
                <p class="mb-0 small text-muted">Remarks:</p>
                <p class="small border-bottom border-light pb-2">{{ $feePayment->remarks ?? 'N/A' }}</p>
            </div>
            <div class="col-6 text-center pt-4">
                <div style="width: 150px; border-top: 1px solid #333; margin: 0 auto 5px auto;"></div>
                <p class="mb-0 small fw-bold">Authorized Signatory</p>
                <p class="mb-0 x-small text-muted">Computer Generated Receipt</p>
            </div>
        </div>

        <div class="mt-5 pt-3 border-top text-center">
            <p class="x-small text-muted mb-0">Thank you for your payment. This is a computer generated receipt.</p>
            @if($school && $school->website)
                <small class="text-muted">{{ $school->website }}</small>
            @endif
        </div>
    </div>
</div>
@endsection
