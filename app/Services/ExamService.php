<?php

namespace App\Services;

use App\Models\Exam;
use Yajra\DataTables\Facades\DataTables;

class ExamService
{
    public function getFormData()
    {
        return [
            'sessions' => \App\Models\AcademicSession::all(),
        ];
    }

    public function getDataTable()
    {
        $data = Exam::with('academicSession')->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('is_active', function($row){
                return $row->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function($row){
                $editBtn = '<a href="'.route('master.exams.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>';
                $deleteBtn = '<form action="'.route('master.exams.destroy', $row->id).'" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure?\')">
                    '.csrf_field().'
                    '.method_field("DELETE").'
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>';
                $scheduleBtn = '<a href="'.route('exams.schedules.index', $row->id).'" class="btn btn-sm btn-info text-white ms-1">Schedule</a>';
                return $editBtn . $scheduleBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['is_active', 'action'])
            ->make(true);
    }

    public function createExam(array $data)
    {
        return Exam::create($data);
    }

    public function updateExam(Exam $exam, array $data)
    {
        return $exam->update($data);
    }

    public function deleteExam(Exam $exam)
    {
        return $exam->delete();
    }
}
