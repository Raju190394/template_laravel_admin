@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-2 px-2">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-xl-8">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary"><i class="fa fa-hand-holding-usd me-2"></i>Collect Fee</h6>
                    <a href="{{ route('fees.payments.index') }}" class="btn btn-sm btn-secondary"><i class="fa fa-arrow-left me-1"></i>Back</a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle me-2"></i>Please correct the errors below.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('fees.payments.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-floating mb-3">
                        <select class="form-select @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->class->class_name ?? 'No Class' }})</option>
                            @endforeach
                        </select>
                        <label for="student_id">Full Name <span class="text-danger">*</span></label>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select @error('fee_structure_id') is-invalid @enderror" id="fee_structure_id" name="fee_structure_id" required disabled>
                            <option value="">Select Fee Head</option>
                        </select>
                        <label for="fee_structure_id">Fee Head <span class="text-danger">*</span></label>
                        <div id="fee_loading" class="form-text text-primary d-none"><i class="fa fa-spinner fa-spin me-1"></i>Fetching fees...</div>
                        @error('fee_structure_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-2">
                        <div class="col-md-8">
                            <div class="form-floating mb-3">
                                <input type="number" step="0.01" class="form-control @error('amount_paid') is-invalid @enderror" id="amount_paid" name="amount_paid" value="{{ old('amount_paid') }}" placeholder="Amount" required>
                                <label for="amount_paid">Amount to Pay (₹) <span class="text-danger">*</span></label>
                                @error('amount_paid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" required>
                                <label for="payment_date">Payment Date <span class="text-danger">*</span></label>
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select @error('for_month') is-invalid @enderror" id="for_month" name="for_month">
                                    <option value="">Select Month</option>
                                    @php
                                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    @endphp
                                    @foreach($months as $month)
                                        <option value="{{ $month }}" {{ date('F') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                                <label for="for_month">Fee Month</label>
                                @error('for_month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('for_year') is-invalid @enderror" id="for_year" name="for_year" value="{{ date('Y') }}" required>
                                <label for="for_year">Fee Year <span class="text-danger">*</span></label>
                                @error('for_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                            <option value="Cash">Cash</option>
                            <option value="Online">Online</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                        <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                    </div>

                    <div id="transaction_block" class="form-floating mb-3 d-none">
                        <input type="text" class="form-control @error('transaction_id') is-invalid @enderror" id="transaction_id" name="transaction_id" value="{{ old('transaction_id') }}" placeholder="Transaction ID">
                        <label for="transaction_id">Transaction ID / Cheque No.</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks" style="height: 80px;">{{ old('remarks') }}</textarea>
                        <label for="remarks">Remarks (Optional)</label>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="reset" class="btn btn-light me-2">Reset</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Collect Fee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#student_id').change(function() {
            var studentId = $(this).val();
            var feeSelect = $('#fee_structure_id');
            var loading = $('#fee_loading');
            
            if (studentId) {
                feeSelect.prop('disabled', true);
                loading.removeClass('d-none');
                
                $.ajax({
                    url: '/fees/payments/get-student-fees/' + studentId,
                    type: 'GET',
                    success: function(data) {
                        feeSelect.empty().append('<option value="">Select Fee Head</option>');
                        $.each(data.fees, function(key, value) {
                            feeSelect.append('<option value="' + value.id + '" data-amount="' + value.amount + '">' + value.fee_head + ' (₹' + value.amount + ')</option>');
                        });
                        feeSelect.prop('disabled', false);
                        loading.addClass('d-none');
                    }
                });
            } else {
                feeSelect.empty().append('<option value="">Select Fee Head</option>').prop('disabled', true);
            }
        });

        $('#fee_structure_id').change(function() {
            var amount = $(this).find(':selected').data('amount');
            if (amount) {
                $('#amount_paid').val(amount);
            }
        });

        $('#payment_method').change(function() {
            if ($(this).val() !== 'Cash') {
                $('#transaction_block').removeClass('d-none');
            } else {
                $('#transaction_block').addClass('d-none');
            }
        });
    });
</script>
@endpush
@endsection
