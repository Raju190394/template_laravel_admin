@extends('layouts.admin')

@section('content')
<!-- KPI Cards Start -->
<div class="container-xxl pt-2 px-2">
    <div class="row g-4">
        <!-- Total Students -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-white rounded p-4 border shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                        <i class="fa fa-user-graduate fa-2x text-primary"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted small">Total Students</p>
                        <h4 class="mb-0 fw-bold">{{ number_format($kpis['total_students']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Fee Collection -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-white rounded p-4 border shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                        <i class="fa fa-dollar-sign fa-2x text-success"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted small">Monthly Collection</p>
                        <h4 class="mb-0 fw-bold">₹{{ number_format($kpis['monthly_fee_collection'], 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Percentage -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-white rounded p-4 border shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 rounded p-3 me-3">
                        <i class="fa fa-chart-line fa-2x text-info"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted small">Attendance Today</p>
                        <h4 class="mb-0 fw-bold">{{ $kpis['attendance_percentage'] }}%</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Defaulters Count -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-white rounded p-4 border shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 rounded p-3 me-3">
                        <i class="fa fa-exclamation-triangle fa-2x text-warning"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted small">Fee Defaulters</p>
                        <h4 class="mb-0 fw-bold">{{ number_format($kpis['defaulters_count']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- KPI Cards End -->

<!-- Charts Row Start -->
<div class="container-xxl pt-2 px-2">
    <div class="row g-4">
        <!-- Monthly Fee Collection Chart -->
        <div class="col-xl-8">
            <div class="bg-white rounded p-4 border shadow-sm">
                <h6 class="mb-4 fw-bold"><i class="fa fa-chart-bar me-2 text-primary"></i>Monthly Fee Collection (Last 6 Months)</h6>
                <canvas id="feeCollectionChart" height="80"></canvas>
            </div>
        </div>

        <!-- Students by Class Chart -->
        <div class="col-xl-4">
            <div class="bg-white rounded p-4 border shadow-sm">
                <h6 class="mb-4 fw-bold"><i class="fa fa-chart-pie me-2 text-success"></i>Students by Class</h6>
                <canvas id="studentsByClassChart"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- Charts Row End -->

<!-- Attendance Trend & Defaulters Start -->
<div class="container-xxl pt-2 px-2">
    <div class="row g-4">
        <!-- Attendance Trend Chart -->
        <div class="col-xl-7">
            <div class="bg-white rounded p-4 border shadow-sm">
                <h6 class="mb-4 fw-bold"><i class="fa fa-chart-line me-2 text-info"></i>Attendance Trend (Last 7 Days)</h6>
                <canvas id="attendanceTrendChart" height="80"></canvas>
            </div>
        </div>

        <!-- Defaulters List -->
        <div class="col-xl-5">
            <div class="bg-white rounded p-4 border shadow-sm">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 fw-bold"><i class="fa fa-exclamation-circle me-2 text-warning"></i>Fee Defaulters</h6>
                    <a href="{{ route('fees.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover table-sm align-middle mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Student</th>
                                <th>Class</th>
                                <th class="text-end">Pending</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($defaulters as $defaulter)
                            <tr>
                                <td class="fw-bold">{{ $defaulter->name }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $defaulter->class->class_name ?? 'N/A' }}</span></td>
                                <td class="text-end text-danger fw-bold">₹{{ number_format($defaulter->pending_amount ?? 0, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    <i class="fa fa-check-circle me-1"></i> No defaulters found
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
<!-- Attendance Trend & Defaulters End -->

<!-- Recent Activities Start -->
<div class="container-xxl pt-2 px-2 pb-4">
    <div class="row g-4">
        <!-- Recent Students -->
        <div class="col-xl-6">
            <div class="bg-white rounded p-4 border shadow-sm">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 fw-bold"><i class="fa fa-clock me-2 text-primary"></i>Recent Students</h6>
                    <a href="{{ route('students.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities['recent_students'] as $student)
                            <tr>
                                <td class="fw-bold">{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $student->created_at->diffForHumans() }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    <i class="fa fa-info-circle me-1"></i> No recent students
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Fee Payments -->
        <div class="col-xl-6">
            <div class="bg-white rounded p-4 border shadow-sm">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 fw-bold"><i class="fa fa-money-bill-wave me-2 text-success"></i>Recent Payments</h6>
                    <a href="{{ route('fees.index') }}" class="btn btn-sm btn-success">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities['recent_fees'] as $fee)
                            <tr>
                                <td class="fw-bold">{{ $fee->student->name ?? 'N/A' }}</td>
                                <td class="text-success fw-bold">₹{{ number_format($fee->amount_paid, 2) }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $fee->payment_date ? \Carbon\Carbon::parse($fee->payment_date)->format('M d, Y') : 'N/A' }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    <i class="fa fa-info-circle me-1"></i> No recent payments
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
<!-- Recent Activities End -->

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Monthly Fee Collection Chart (Bar Chart)
const feeCtx = document.getElementById('feeCollectionChart').getContext('2d');
new Chart(feeCtx, {
    type: 'bar',
    data: {
        labels: @json($feeChart['labels']),
        datasets: [{
            label: 'Fee Collection (₹)',
            data: @json($feeChart['data']),
            backgroundColor: 'rgba(13, 110, 253, 0.8)',
            borderColor: 'rgba(13, 110, 253, 1)',
            borderWidth: 1,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return '₹' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '₹' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Students by Class Chart (Pie Chart)
const classCtx = document.getElementById('studentsByClassChart').getContext('2d');
new Chart(classCtx, {
    type: 'pie',
    data: {
        labels: @json($studentsByClass['labels']),
        datasets: [{
            data: @json($studentsByClass['data']),
            backgroundColor: [
                'rgba(13, 110, 253, 0.8)',
                'rgba(25, 135, 84, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(220, 53, 69, 0.8)',
                'rgba(13, 202, 240, 0.8)',
                'rgba(108, 117, 125, 0.8)',
                'rgba(111, 66, 193, 0.8)',
                'rgba(253, 126, 20, 0.8)',
                'rgba(214, 51, 132, 0.8)',
                'rgba(32, 201, 151, 0.8)'
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 10,
                    font: {
                        size: 11
                    }
                }
            }
        }
    }
});

// Attendance Trend Chart (Line Chart)
const attendanceCtx = document.getElementById('attendanceTrendChart').getContext('2d');
new Chart(attendanceCtx, {
    type: 'line',
    data: {
        labels: @json($attendanceTrend['labels']),
        datasets: [{
            label: 'Attendance %',
            data: @json($attendanceTrend['data']),
            borderColor: 'rgba(13, 202, 240, 1)',
            backgroundColor: 'rgba(13, 202, 240, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: 'rgba(13, 202, 240, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    callback: function(value) {
                        return value + '%';
                    }
                }
            }
        }
    }
});
</script>
@endpush
@endsection
