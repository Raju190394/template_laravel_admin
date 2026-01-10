@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-2 px-2">
    <div class="row">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary"><i class="fa fa-dollar-sign me-2"></i>Fee Structures</h6>
                    <a href="{{ route('master.fee-structures.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus me-1"></i>Add Fee Structure
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
                                <th>#</th>
                                <th>Class</th>
                                <th>Fee Head</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Frequency</th>
                                <th>Mandatory</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feeStructures as $feeStructure)
                                <tr>
                                    <td>{{ $loop->iteration + ($feeStructures->currentPage() - 1) * $feeStructures->perPage() }}</td>
                                    <td>
                                        <strong>{{ $feeStructure->class->class_name }}</strong>
                                        @if($feeStructure->class->section)
                                            - {{ $feeStructure->class->section }}
                                        @endif
                                    </td>
                                    <td>{{ $feeStructure->fee_head }}</td>
                                    <td><strong class="text-success">₹{{ number_format($feeStructure->amount, 2) }}</strong></td>
                                    <td><span class="badge bg-info">{{ $feeStructure->fee_type }}</span></td>
                                    <td><span class="badge bg-secondary">{{ $feeStructure->frequency }}</span></td>
                                    <td>
                                        @if($feeStructure->is_mandatory)
                                            <span class="badge bg-danger">Mandatory</span>
                                        @else
                                            <span class="badge bg-warning">Optional</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('master.fee-structures.edit', $feeStructure) }}" 
                                               class="btn btn-sm btn-outline-info" title="Edit">
                                                <i class="fa fa-pen"></i>
                                            </a>
                                            <form action="{{ route('master.fee-structures.destroy', $feeStructure) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger ms-1" 
                                                        onclick="return confirm('Are you sure you want to delete this fee structure?')" 
                                                        title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No fee structures found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $feeStructures->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
