<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $kpis = $this->dashboardService->getKPIs();
        $defaulters = $this->dashboardService->getDefaultersList(10);
        $feeChart = $this->dashboardService->getMonthlyFeeCollectionChart();
        $studentsByClass = $this->dashboardService->getStudentsByClassChart();
        $attendanceTrend = $this->dashboardService->getAttendanceTrendChart(7);
        $activities = $this->dashboardService->getRecentActivities(5);

        return view('dashboard', compact(
            'kpis',
            'defaulters',
            'feeChart',
            'studentsByClass',
            'attendanceTrend',
            'activities'
        ));
    }
}
