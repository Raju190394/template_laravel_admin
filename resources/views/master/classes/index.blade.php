@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-2 px-2">
    <div class="row">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary"><i class="fa fa-graduation-cap me-2"></i>Classes Management</h6>
                    <a href="{{ route('master.classes.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus me-1"></i>Add New Class
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
                                <th>Class Name</th>
                                <th>Section</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classes as $class)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $class->class_name }}</strong></td>
                                    <td>{{ $class->section ?? 'N/A' }}</td>
                                    <td>{{ $class->capacity ?? 'N/A' }}</td>
                                    <td>
                                        @if($class->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('master.classes.edit', $class) }}" 
                                               class="btn btn-sm btn-outline-info" title="Edit">
                                                <i class="fa fa-pen"></i>
                                            </a>
                                            <form action="{{ route('master.classes.destroy', $class) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger ms-1" 
                                                        onclick="return confirm('Are you sure you want to delete this class?')" 
                                                        title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No classes found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $classes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
