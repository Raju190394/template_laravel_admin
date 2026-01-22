<?php

namespace App\Services;

use App\Models\Student;
use App\Models\User;
use App\Models\Course;
use App\Models\Classes;
use App\Models\Staff;
use App\Models\FeePayment;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getKPIs()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        
        return [
            'total_students' => Student::count(),
            'total_staff' => Staff::count(),
            'total_classes' => Classes::count(),
            'total_courses' => Course::count(),
            'monthly_fee_collection' => FeePayment::whereYear('payment_date', Carbon::now()->year)
                ->whereMonth('payment_date', Carbon::now()->month)
                ->sum('amount_paid'),
            'attendance_percentage' => $this->getAttendancePercentage(),
            'defaulters_count' => $this->getDefaultersCount(),
        ];
    }

    public function getAttendancePercentage()
    {
        $today = Carbon::today();
        $totalRecords = Attendance::whereDate('date', $today)->count();
        
        if ($totalRecords === 0) {
            return 0;
        }
        
        $presentRecords = Attendance::whereDate('date', $today)
            ->where('status', 'Present')
            ->count();
            
        return round(($presentRecords / $totalRecords) * 100, 2);
    }

    public function getDefaultersCount()
    {
        // TODO: Implement proper defaulters logic based on FeeStructure vs FeePayment
        // For now returning 0 to prevent "column not found" errors
        return 0;
    }

    public function getDefaultersList($limit = 10)
    {
        // TODO: Implement proper defaulters list logic
        return collect([]);
    }

    public function getMonthlyFeeCollectionChart()
    {
        $months = [];
        $collections = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $collection = FeePayment::whereYear('payment_date', $date->year)
                ->whereMonth('payment_date', $date->month)
                ->sum('amount_paid');
                
            $collections[] = $collection;
        }
        
        return [
            'labels' => $months,
            'data' => $collections
        ];
    }

    public function getStudentsByClassChart()
    {
        $classData = Classes::withCount('students')
            ->orderBy('class_name')
            ->get();
            
        return [
            'labels' => $classData->pluck('class_name')->toArray(),
            'data' => $classData->pluck('students_count')->toArray()
        ];
    }

    public function getAttendanceTrendChart($days = 7)
    {
        $dates = [];
        $percentages = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dates[] = $date->format('M d');
            
            $totalRecords = Attendance::whereDate('date', $date)->count();
            
            if ($totalRecords > 0) {
                $presentRecords = Attendance::whereDate('date', $date)
                    ->where('status', 'Present')
                    ->count();
                $percentages[] = round(($presentRecords / $totalRecords) * 100, 2);
            } else {
                $percentages[] = 0;
            }
        }
        
        return [
            'labels' => $dates,
            'data' => $percentages
        ];
    }

    public function getRecentActivities($limit = 5)
    {
        return [
            'recent_students' => Student::latest()->limit($limit)->get(),
            'recent_fees' => FeePayment::with('student')->latest()->limit($limit)->get(),
        ];
    }
}
