@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="bg-white rounded p-4 d-flex justify-content-between align-items-center shadow-sm">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="{{ route('parent.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('parent.student.view', $student->id) }}">{{ $student->name }}</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ol>
                    </nav>
                    <h4 class="mb-0">Attendance History</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded p-4 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendance as $att)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                            <td>
                                @if($att->status == 'Present')
                                    <span class="badge bg-success">Present</span>
                                @elseif($att->status == 'Absent')
                                    <span class="badge bg-danger">Absent</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ $att->status }}</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $att->remarks ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $attendance->links() }}
    </div>
</div>
@endsection
