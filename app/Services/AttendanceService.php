<?php

namespace App\Services;

use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceService
{
    public function getDataTable()
    {
        $query = Attendance::with('staff');
        
        if (auth()->user()->role === 'staff') {
            $staffId = auth()->user()->staff->id ?? 0;
            $query->where('staff_id', $staffId);
        }
        
        $data = $query->latest()->get();
        return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('staff_name', function($row){
                return $row->staff->name;
            })
            ->editColumn('date', function($row){
                return $row->date->format('d M, Y');
            })
            ->make(true);
    }
    public function markAttendance(array $data)
    {
        $staffId = $data['staff_id'];
        $today = Carbon::today();

        // Check for unauthorized access if current user is staff
        if (auth()->user()->role === 'staff') {
            $myStaff = auth()->user()->staff;
            if (!$myStaff || $myStaff->id != $staffId) {
                return [
                    'success' => false,
                    'message' => 'Unauthorized attendance marking.'
                ];
            }
        }

        $attendance = Attendance::updateOrCreate(
            ['staff_id' => $staffId, 'date' => $today],
            [
                'check_in' => Carbon::now()->format('H:i:s'),
                'status' => $data['status'],
                'auth_method' => $data['auth_method'],
                'remarks' => $data['remarks'] ?? 'Marked via ' . $data['auth_method']
            ]
        );

        return [
            'success' => true,
            'message' => 'Attendance marked successfully for ' . $attendance->staff->name,
            'data' => $attendance
        ];
    }
}
