@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-white rounded h-100 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 ignore-print">
            <h6 class="mb-0">Report: {{ $exam->name }} - {{ $class->class_name }} {{ $class->section }}</h6>
            <div>
                <button onclick="window.print()" class="btn btn-secondary me-2">Print</button>
                <a href="{{ route('exams.reports.index') }}" class="btn btn-outline-primary">Back</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr class="bg-light">
                        <th class="text-start">Student Name</th>
                        @foreach($schedules as $schedule)
                            <th>{{ $schedule->course->name }} <br><small class="text-muted">({{ $schedule->full_marks }})</small></th>
                        @endforeach
                        <th>Total <br><small>({{ $reportData[array_key_first($reportData)]['max_total'] ?? 0 }})</small></th>
                        <th>percentage</th>
                        <th>Grade</th> <!-- Placeholder -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData as $data)
                        <tr>
                            <td class="text-start fw-bold">{{ $data['name'] }}</td>
                            @foreach($schedules as $schedule)
                                @php $val = $data['marks'][$schedule->course_id]; @endphp
                                <td class="{{ $val === 'Abs' ? 'text-danger' : '' }}">{{ $val }}</td>
                            @endforeach
                            <td class="fw-bold">{{ $data['total'] }}</td>
                            <td>{{ $data['percentage'] }}%</td>
                            <td>
                                @if($data['percentage'] >= 90) A+
                                @elseif($data['percentage'] >= 80) A
                                @elseif($data['percentage'] >= 70) B
                                @elseif($data['percentage'] >= 60) C
                                @elseif($data['percentage'] >= 40) D
                                @else <span class="text-danger">F</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .navbar, .ignore-print, .footer {
            display: none !important;
        }
        .content {
            margin: 0 !important;
            width: 100% !important;
        }
        .container-fluid {
            padding: 0 !important;
        }
    }
</style>
@endsection
