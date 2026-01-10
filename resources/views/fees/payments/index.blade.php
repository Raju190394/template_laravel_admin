@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-2 px-2">
    <div class="row">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary"><i class="fa fa-money-bill-wave me-2"></i>Fee Payments</h6>
                    <a href="{{ route('fees.payments.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus me-1"></i>Collect New Fee
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Receipt #</th>
                                <th>Student</th>
                                <th>Fee Head</th>
                                <th>Amount</th>
                                <th>Period</th>
                                <th>Date</th>
                                <th>Method</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $payment->receipt_no }}</span></td>
                                    <td>
                                        <strong>{{ $payment->student->name ?? 'Deleted Student' }}</strong><br>
                                        <small class="text-muted">{{ $payment->student->class->class_name ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ $payment->feeStructure->fee_head ?? 'N/A' }}</td>
                                    <td><strong class="text-success">₹{{ number_format($payment->amount_paid, 2) }}</strong></td>
                                    <td>{{ $payment->for_month }} {{ $payment->for_year }}</td>
                                    <td>{{ $payment->payment_date ? $payment->payment_date->format('d M, Y') : 'N/A' }}</td>
                                    <td><span class="badge bg-info">{{ $payment->payment_method }}</span></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('fees.payments.show', $payment) }}" 
                                               class="btn btn-sm btn-outline-primary" title="View Receipt">
                                                <i class="fa fa-file-invoice"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No payments found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
