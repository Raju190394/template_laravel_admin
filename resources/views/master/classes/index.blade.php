@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Classes Management</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Classes</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('master.classes.create') }}" class="btn btn-primary shadow">
            <i class="fa-solid fa-plus me-2"></i>Add New Class
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="fa-solid fa-circle-check fs-5 me-3 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-list me-2 text-primary"></i>All Classes</h6>
                </div>
                <div class="col-auto">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" class="form-control" placeholder="Search classes...">
                        <span class="input-group-text bg-transparent"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Class Name</th>
                            <th>Section</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $class)
                            <tr>
                                <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $class->class_name }}</div>
                                </td>
                                <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $class->section ?? 'N/A' }}</span></td>
                                <td>{{ $class->capacity ?? 'N/A' }}</td>
                                <td>
                                    @if($class->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('master.classes.edit', $class) }}" 
                                           class="btn btn-sm btn-white border" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-info"></i>
                                        </a>
                                        <form action="{{ route('master.classes.destroy', $class) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-white border ms-1" 
                                                    onclick="return confirm('Are you sure?')" 
                                                    title="Delete">
                                                <i class="fa-solid fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fa-solid fa-folder-open fa-3x mb-3 opacity-25"></i>
                                        <p>No classes found in the system.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($classes->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-end">
                {{ $classes->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
