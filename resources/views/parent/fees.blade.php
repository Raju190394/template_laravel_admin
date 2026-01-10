@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="bg-white rounded p-4 d-flex justify-content-between align-items-center shadow-sm">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="{{ route('parent.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('parent.student.view', $student->id) }}">{{ $student->name }}</a></li>
                            <li class="breadcrumb-item active">Fees</li>
                        </ol>
                    </nav>
                    <h4 class="mb-0">Fees & Payment History</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded p-4 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Receipt #</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td><span class="fw-bold">{{ $payment->receipt_no }}</span></td>
                            <td>{{ number_format($payment->amount_paid, 2) }}</td>
                            <td>{{ $payment->payment_method }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('fees.payments.pdf', $payment->id) }}" class="btn btn-sm btn-outline-danger" target="_blank">
                                    <i class="fa fa-file-pdf me-1"></i> Receipt
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">No payments recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
