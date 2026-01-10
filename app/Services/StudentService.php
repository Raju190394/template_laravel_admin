<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class StudentService
{
    public function getDataTable()
    {
        $data = Student::with('class')->latest();
        return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('class', function($row) {
                return $row->class ? ($row->class->class_name . ' - ' . $row->class->section) : '<span class="text-danger">Not Assigned</span>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<a href="'.route('students.edit', $row->id).'" class="btn btn-sm btn-outline-info" title="Edit"><i class="fa fa-pen"></i></a>';
                $btn .= '<form action="'.route('students.destroy', $row->id).'" method="POST" class="d-inline delete-form">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm(\'Are you sure you want to delete this student?\')" title="Delete"><i class="fa fa-trash"></i></button></form>';
                $btn .= '</div>';
                return $btn;
            })
            ->editColumn('dob', function($row) {
                return $row->dob ? \Carbon\Carbon::parse($row->dob)->format('d M, Y') : '-';
            })
            ->addColumn('photo', function($row){
                $url = $row->photo ? asset('storage/' . $row->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($row->name) . '&background=random';
                return '<img src="'.$url.'" class="rounded-circle" width="40" height="40" style="object-fit: cover;">';
            })
            ->rawColumns(['action', 'class', 'photo'])
            ->make(true);
    }
    public function getAllStudents()
    {
        return Student::all();
    }

    public function createStudent(array $data)
    {
        if (request()->hasFile('photo')) {
            $data['photo'] = request()->file('photo')->store('student_photos', 'public');
        }
        return Student::create($data);
    }

    public function updateStudent(Student $student, array $data)
    {
        if (request()->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = request()->file('photo')->store('student_photos', 'public');
        }
        return $student->update($data);
    }

    public function deleteStudent(Student $student)
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }
        return $student->delete();
    }
}
