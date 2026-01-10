<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staff\StaffStoreRequest;
use App\Http\Requests\Staff\StaffUpdateRequest;
use App\Models\Staff;
use App\Services\StaffService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{
    protected $staffService;

    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->staffService->getDataTable();
        }
        return view('staff.index');
    }

    public function create()
    {
        $users = \App\Models\User::where('role', 'staff')
            ->whereDoesntHave('staff')
            ->get();
        return view('staff.create', compact('users'));
    }

    public function store(StaffStoreRequest $request)
    {
        $this->staffService->createStaff($request->validated());

        return redirect()->route('staff.index')->with('success', 'Staff added successfully.');
    }

    public function edit(Staff $staff)
    {
        $users = \App\Models\User::where('role', 'staff')
            ->where(function($q) use ($staff) {
                $q->whereDoesntHave('staff')
                  ->orWhere('id', $staff->user_id);
            })->get();
        return view('staff.edit', compact('staff', 'users'));
    }

    public function update(StaffUpdateRequest $request, Staff $staff)
    {
        $this->staffService->updateStaff($staff, $request->validated());

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $this->staffService->deleteStaff($staff);
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }
}
