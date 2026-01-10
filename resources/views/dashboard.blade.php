@extends('layouts.admin')

@section('content')
<!-- Stats Cards Start -->
<div class="container-xxl pt-2 px-2">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-4">
            <div class="bg-white rounded p-4 border">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                        <i class="fa fa-users fa-2x text-primary"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted small">Total Users</p>
                        <h4 class="mb-0 fw-bold">{{ $users }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="bg-white rounded p-4 border">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                        <i class="fa fa-user-graduate fa-2x text-success"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted small">Total Students</p>
                        <h4 class="mb-0 fw-bold">{{ $students }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="bg-white rounded p-4 border">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 rounded p-3 me-3">
                        <i class="fa fa-book fa-2x text-info"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted small">Total Courses</p>
                        <h4 class="mb-0 fw-bold">{{ $courses }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Stats Cards End -->

<!-- Quick Actions Start -->
<div class="container-xxl pt-2 px-2">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-white rounded p-4 border">
                <h6 class="mb-4 fw-bold"><i class="fa fa-bolt me-2 text-primary"></i>Quick Actions</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('students.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fa fa-user-plus me-2"></i>Add Student
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('master.courses.create') }}" class="btn btn-outline-success w-100">
                            <i class="fa fa-book-open me-2"></i>Add Course
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('users.create') }}" class="btn btn-outline-info w-100">
                            <i class="fa fa-user-shield me-2"></i>Add User
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary w-100">
                            <i class="fa fa-cog me-2"></i>Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quick Actions End -->

<!-- Recent Students Start -->
<div class="container-xxl pt-2 px-2">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-white rounded p-4 border">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 fw-bold"><i class="fa fa-clock me-2 text-primary"></i>Recent Students</h6>
                    <a href="{{ route('students.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentStudents as $student)
                            <tr>
                                <td class="fw-bold">{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone ?? '-' }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $student->created_at->diffForHumans() }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fa fa-info-circle me-1"></i> No recent students found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Recent Students End -->
@endsection
