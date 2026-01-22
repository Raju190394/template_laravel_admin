@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Dashboard Overview</h4>
            <p class="text-muted mb-0">Welcome back! Here's what's happening today.</p>
        </div>
        <div class="d-none d-sm-block">
            <button class="btn btn-white border shadow-sm me-2"><i class="fa-solid fa-download me-2"></i>Export Report</button>
            <button class="btn btn-primary shadow"><i class="fa-solid fa-plus me-2"></i>Add Activity</button>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Students -->
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="fa-solid fa-user-graduate fa-xl text-primary"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success bg-opacity-10 text-success small">+2.5% <i class="fa-solid fa-arrow-up"></i></span>
                        </div>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold">{{ number_format($kpis['total_students']) }}</h3>
                        <p class="mb-0 text-muted fw-medium">Total Students</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Fee Collection -->
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="fa-solid fa-wallet fa-xl text-success"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success bg-opacity-10 text-success small">+4.8% <i class="fa-solid fa-arrow-up"></i></span>
                        </div>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold">₹{{ number_format($kpis['monthly_fee_collection'], 0) }}</h3>
                        <p class="mb-0 text-muted fw-medium">Monthly Collection</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Today -->
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="fa-solid fa-calendar-check fa-xl text-info"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-danger bg-opacity-10 text-danger small">-1.2% <i class="fa-solid fa-arrow-down"></i></span>
                        </div>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold">{{ $kpis['attendance_percentage'] }}%</h3>
                        <p class="mb-0 text-muted fw-medium">Attendance Today</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Defaulters -->
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="fa-solid fa-triangle-exclamation fa-xl text-warning"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info bg-opacity-10 text-info small">Active</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold">{{ number_format($kpis['defaulters_count']) }}</h3>
                        <p class="mb-0 text-muted fw-medium">Fee Defaulters</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold">Fee Collection Trend</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown">
                            Last 6 Months <i class="fa-solid fa-chevron-down ms-1 small"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="feeCollectionChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold">Students Distribution</h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="studentsByClassChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row g-4">
        <!-- Attendance Trend -->
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold">Attendance Analytics</h6>
                </div>
                <div class="card-body">
                    <canvas id="attendanceTrendChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Defaulters List -->
        <div class="col-xl-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold">Fee Defaulters</h6>
                    <a href="{{ route('fees.payments.index') }}" class="btn btn-sm btn-link text-primary text-decoration-none">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Student</th>
                                    <th>Class</th>
                                    <th class="text-end pe-4">Pending</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($defaulters as $defaulter)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-semibold">{{ $defaulter->name }}</div>
                                    </td>
                                    <td><span class="badge bg-info bg-opacity-10 text-info">{{ $defaulter->class->class_name ?? 'N/A' }}</span></td>
                                    <td class="text-end pe-4 text-danger fw-bold">₹{{ number_format($defaulter->pending_amount ?? 0, 0) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fa-solid fa-circle-check fa-3x mb-3 text-success bg-success bg-opacity-10 p-3 rounded-circle"></i>
                                            <p class="mb-0">All clear! No fee defaulters found.</p>
                                        </div>
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

    <!-- Recent Activities -->
    <div class="row g-4 mt-2">
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold">New Registrations</h6>
                    <a href="{{ route('students.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <tbody>
                                @forelse($activities['recent_students'] as $student)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fa-solid fa-user small"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $student->name }}</div>
                                                <small class="text-muted">{{ $student->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="text-muted small">{{ $student->created_at->diffForHumans() }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="text-center py-4">No recent students</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold">Recent Payments</h6>
                    <a href="{{ route('fees.payments.index') }}" class="btn btn-sm btn-success">History</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <tbody>
                                @forelse($activities['recent_fees'] as $fee)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fa-solid fa-receipt small"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $fee->student->name ?? 'N/A' }}</div>
                                                <small class="text-muted">₹{{ number_format($fee->amount_paid, 0) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="text-muted small">{{ $fee->payment_date ? \Carbon\Carbon::parse($fee->payment_date)->diffForHumans() : 'N/A' }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="text-center py-4">No recent payments</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Chart Defaults
Chart.defaults.font.family = "'Outfit', sans-serif";
Chart.defaults.color = '#64748b';

// Fee Collection Chart
const feeCtx = document.getElementById('feeCollectionChart').getContext('2d');
new Chart(feeCtx, {
    type: 'bar',
    data: {
        labels: @json($feeChart['labels']),
        datasets: [{
            label: 'Collection',
            data: @json($feeChart['data']),
            backgroundColor: '#6366f1',
            borderRadius: 8,
            barThickness: 25,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { display: false } },
            x: { grid: { display: false } }
        }
    }
});

// Distribution Chart
const classCtx = document.getElementById('studentsByClassChart').getContext('2d');
new Chart(classCtx, {
    type: 'doughnut',
    data: {
        labels: @json($studentsByClass['labels']),
        datasets: [{
            data: @json($studentsByClass['data']),
            backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#0ea5e9'],
            offset: 10,
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        cutout: '70%',
        plugins: { legend: { position: 'bottom' } }
    }
});

// Attendance Trend Chart
const attendanceCtx = document.getElementById('attendanceTrendChart').getContext('2d');
new Chart(attendanceCtx, {
    type: 'line',
    data: {
        labels: @json($attendanceTrend['labels']),
        datasets: [{
            label: 'Attendance %',
            data: @json($attendanceTrend['data']),
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointRadius: 4,
            pointBackgroundColor: '#fff',
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { min: 0, max: 100, grid: { borderDash: [5, 5] } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush
@endsection
