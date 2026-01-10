<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceStoreRequest;
use App\Models\Staff;
use App\Models\Attendance;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->attendanceService->getDataTable();
        }
        return view('attendance.index');
    }

    public function mark()
    {
        if (auth()->user()->role === 'staff') {
            $staff = auth()->user()->staff;
            if (!$staff) {
                return redirect()->route('dashboard')->with('error', 'Staff profile not found.');
            }
            $staffMembers = collect([$staff]);
        } else {
            $staffMembers = Staff::where('is_active', true)->get();
        }
        
        return view('attendance.mark', compact('staffMembers'));
    }

    public function storeMark(AttendanceStoreRequest $request)
    {
        $result = $this->attendanceService->markAttendance($request->validated());

        return response()->json($result);
    }
}
