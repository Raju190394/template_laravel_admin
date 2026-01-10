@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-4 px-4">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-xl-8">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-primary"><i class="fa fa-user-graduate me-2"></i>Student Details</h6>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>

                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <div class="profile-img-container">
                            @if($student->photo)
                                <img src="{{ asset('storage/' . $student->photo) }}" class="img-thumbnail rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=200&background=random" class="img-thumbnail rounded-circle" alt="Dummy Image">
                            @endif
                        </div>
                        <h4 class="mt-3">{{ $student->name }}</h4>
                        <span class="badge bg-primary">{{ $student->class ? $student->class->class_name . ' - ' . $student->class->section : 'No Class' }}</span>
                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Email:</th>
                                    <td>{{ $student->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $student->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>DOB:</th>
                                    <td>{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d M, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At:</th>
                                    <td>{{ $student->created_at->format('d M, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-info text-white"><i class="fa fa-edit me-1"></i>Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
