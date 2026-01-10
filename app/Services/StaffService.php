<?php

namespace App\Services;

use App\Models\Staff;
use Illuminate\Support\Facades\Storage;

class StaffService
{
    public function getDataTable()
    {
        $data = Staff::latest()->get();
        return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('photo', function($row){
                $url = $row->photo ? asset('storage/' . $row->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($row->name) . '&background=random';
                return '<img src="'.$url.'" class="rounded-circle" width="40" height="40" style="object-fit: cover;">';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="btn-group">';
                $btn .= '<a href="'.route('staff.edit', $row->id).'" class="btn btn-sm btn-outline-info"><i class="fa fa-edit"></i></a>';
                $btn .= '<form action="'.route('staff.destroy', $row->id).'" method="POST" class="d-inline">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash"></i></button></form>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['photo', 'action'])
            ->make(true);
    }
    public function createStaff(array $data)
    {
        if (request()->hasFile('photo')) {
            $data['photo'] = request()->file('photo')->store('staff_photos', 'public');
        }

        return Staff::create($data);
    }

    public function updateStaff(Staff $staff, array $data)
    {
        if (request()->hasFile('photo')) {
            if ($staff->photo) {
                Storage::disk('public')->delete($staff->photo);
            }
            $data['photo'] = request()->file('photo')->store('staff_photos', 'public');
        }

        $data['is_active'] = isset($data['is_active']) ? (bool)$data['is_active'] : false;

        return $staff->update($data);
    }

    public function deleteStaff(Staff $staff)
    {
        if ($staff->photo) {
            Storage::disk('public')->delete($staff->photo);
        }
        return $staff->delete();
    }
}
