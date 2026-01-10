@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-2 px-2">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-xl-8">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary">
                        <i class="fa fa-{{ isset($feeStructure) ? 'edit' : 'plus' }} me-2"></i>
                        {{ isset($feeStructure) ? 'Edit' : 'Add' }} Fee Structure
                    </h6>
                    <a href="{{ route('master.fee-structures.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i>Back
                    </a>
                </div>

                <div class="alert alert-info py-2 small mb-4">
                    <i class="fa fa-info-circle me-1"></i> Note: Fee defined here will apply to <strong>all sections</strong> of the selected class.
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle me-2"></i>Please correct the errors below.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ isset($feeStructure) ? route('master.fee-structures.update', $feeStructure) : route('master.fee-structures.store') }}" 
                      method="POST">
                    @csrf
                    @if(isset($feeStructure))
                        @method('PUT')
                    @endif

                    <div class="form-floating mb-3">
                        <select class="form-select @error('class_name_select') is-invalid @enderror" 
                                id="class_name_select" name="class_name_select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->class_name }}" 
                                        {{ old('class_name_select', $currentClassName ?? '') == $class->class_name ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="class_name_select">Class (All Sections) <span class="text-danger">*</span></label>
                        @error('class_name_select')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('fee_head') is-invalid @enderror" 
                               id="fee_head" name="fee_head" 
                               value="{{ old('fee_head', $feeStructure->fee_head ?? '') }}" 
                               placeholder="Fee Head" required>
                        <label for="fee_head">Fee Head <span class="text-danger">*</span></label>
                        <div class="form-text">E.g., Tuition Fee, Library Fee, Lab Fee, Transport Fee</div>
                        @error('fee_head')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                               id="amount" name="amount" 
                               value="{{ old('amount', $feeStructure->amount ?? '') }}" 
                               placeholder="Amount" step="0.01" min="0" required>
                        <label for="amount">Amount (₹) <span class="text-danger">*</span></label>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select @error('fee_type') is-invalid @enderror" 
                                        id="fee_type" name="fee_type" required>
                                    <option value="">Select Fee Type</option>
                                    <option value="Monthly" {{ old('fee_type', $feeStructure->fee_type ?? '') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Quarterly" {{ old('fee_type', $feeStructure->fee_type ?? '') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="Half-Yearly" {{ old('fee_type', $feeStructure->fee_type ?? '') == 'Half-Yearly' ? 'selected' : '' }}>Half-Yearly</option>
                                    <option value="Yearly" {{ old('fee_type', $feeStructure->fee_type ?? '') == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                                    <option value="One-Time" {{ old('fee_type', $feeStructure->fee_type ?? '') == 'One-Time' ? 'selected' : '' }}>One-Time</option>
                                </select>
                                <label for="fee_type">Fee Type <span class="text-danger">*</span></label>
                                @error('fee_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select @error('frequency') is-invalid @enderror" 
                                        id="frequency" name="frequency" required>
                                    <option value="">Select Frequency</option>
                                    <option value="One-Time" {{ old('frequency', $feeStructure->frequency ?? '') == 'One-Time' ? 'selected' : '' }}>One-Time</option>
                                    <option value="Monthly" {{ old('frequency', $feeStructure->frequency ?? '') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Quarterly" {{ old('frequency', $feeStructure->frequency ?? '') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="Yearly" {{ old('frequency', $feeStructure->frequency ?? '') == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                                <label for="frequency">Frequency <span class="text-danger">*</span></label>
                                @error('frequency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_mandatory" name="is_mandatory" value="1"
                               {{ old('is_mandatory', $feeStructure->is_mandatory ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_mandatory">
                            Mandatory Fee (All students must pay this fee)
                        </label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" 
                                  placeholder="Description" style="height: 100px;">{{ old('description', $feeStructure->description ?? '') }}</textarea>
                        <label for="description">Description</label>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="reset" class="btn btn-light me-2">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i>{{ isset($feeStructure) ? 'Update' : 'Create' }} Fee Structure
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
