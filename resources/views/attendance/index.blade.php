@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary"><i class="fa fa-calendar-check me-2"></i>Staff Attendance List</h6>
                    <a href="{{ route('attendance.mark') }}" class="btn btn-primary"><i class="fa fa-camera me-1"></i>Face Auth Attendance</a>
                </div>

                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0" id="attendanceTable">
                        <thead>
                            <tr class="text-dark">
                                <th scope="col">#</th>
                                <th scope="col">Staff Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Check In</th>
                                <th scope="col">Status</th>
                                <th scope="col">Method</th>
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
        $('#attendanceTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('attendance.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'staff_name', name: 'staff_name'},
                {data: 'date', name: 'date'},
                {data: 'check_in', name: 'check_in'},
                {
                    data: 'status', 
                    name: 'status',
                    render: function(data) {
                        let color = 'success';
                        if(data == 'Absent') color = 'danger';
                        if(data == 'Late') color = 'warning';
                        return '<span class="badge bg-'+color+'">'+data+'</span>';
                    }
                },
                {data: 'auth_method', name: 'auth_method'},
            ]
        });
    });
</script>
@endpush
@endsection
