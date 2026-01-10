@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-2 px-2">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary"><i class="fa fa-book me-2"></i>Courses List</h6>
                    <a href="{{ route('master.courses.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus me-1"></i>Add New Course</a>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="coursesTable" class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead class="table-light">
                            <tr class="text-dark">
                                <th scope="col" width="5%">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Price</th>
                                <th scope="col" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#coursesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master.courses.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description', orderable: false, searchable: false},
                {data: 'duration', name: 'duration'},
                {data: 'price', name: 'price'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush
@endsection
