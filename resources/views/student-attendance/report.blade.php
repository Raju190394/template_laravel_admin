@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-white rounded h-100 p-4">
                <h6 class="mb-4">Monthly Attendance Report</h6>

                <form action="{{ route('student-attendance.report') }}" method="GET" class="row g-3 mb-4 border-bottom pb-4 no-print">
                    <div class="col-md-5">
                        <label for="class_id" class="form-label">Class</label>
                        <select class="form-select" name="class_id" id="class_id" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }} {{ $class->section }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="month" class="form-label">Month</label>
                        <input type="month" class="form-control" name="month" id="month" value="{{ request('month', date('Y-m')) }}" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Generate</button>
                    </div>
                </form>

                @if(request('class_id') && request('month'))
                    <div class="d-flex justify-content-between mb-3">
                        <h5>Report for {{ \Carbon\Carbon::parse(request('month'))->format('F Y') }}</h5>
                        <button onclick="window.print()" class="btn btn-secondary no-print"><i class="fa fa-print"></i> Print / PDF</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Student</th>
                                    @php
                                        $daysInMonth = \Carbon\Carbon::parse(request('month'))->daysInMonth;
                                        $monthPrefix = request('month');
                                    @endphp
                                    @for($d=1; $d<=$daysInMonth; $d++)
                                        <th class="text-center" style="font-size: 0.8rem; padding: 2px;">{{ $d }}</th>
                                    @endfor
                                    <th class="text-center">Total</th>
                                    <th class="text-center">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($summary as $data)
                                    <tr>
                                        <td>{{ $data['student']->name }}</td>
                                        @for($d=1; $d<=$daysInMonth; $d++)
                                            @php
                                                $dateStr = sprintf('%s-%02d', $monthPrefix, $d);
                                                $status = $data['details'][$dateStr]->status ?? '-';
                                                $badgeClass = '';
                                                $shortStatus = '-';
                                                
                                                if($status == 'Present') { $shortStatus = 'P'; $badgeClass = 'text-success fw-bold'; }
                                                elseif($status == 'Absent') { $shortStatus = 'A'; $badgeClass = 'text-danger fw-bold'; }
                                                elseif($status == 'Late') { $shortStatus = 'L'; $badgeClass = 'text-warning fw-bold'; }
                                                elseif($status == 'Half Day') { $shortStatus = 'HD'; $badgeClass = 'text-info fw-bold'; }
                                                elseif($status == 'Holiday') { $shortStatus = 'H'; $badgeClass = 'text-secondary'; }
                                            @endphp
                                            <td class="text-center {{ $badgeClass }}" style="font-size: 0.8rem; padding: 2px;">
                                                {{ $shortStatus }}
                                            </td>
                                        @endfor
                                        <td class="text-center fw-bold">{{ $data['present'] }}/{{ $data['total'] }}</td>
                                        <td class="text-center fw-bold {{ $data['percentage'] < 75 ? 'text-danger' : 'text-success' }}">
                                            {{ $data['percentage'] }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print, .sidebar, .navbar {
            display: none !important;
        }
        .content {
            margin: 0 !important;
            width: 100% !important;
        }
    }
</style>
@endsection
