<?php

namespace App\Services;

use App\Models\Course;

class CourseService
{
    public function getAllCourses()
    {
        return Course::latest()->get();
    }

    public function getDataTable()
    {
        $data = Course::latest()->get();
        return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<a href="'.route('master.courses.edit', $row->id).'" class="btn btn-sm btn-outline-info" title="Edit"><i class="fa fa-pen"></i></a>';
                $btn .= '<form action="'.route('master.courses.destroy', $row->id).'" method="POST" class="d-inline delete-form">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm(\'Are you sure you want to delete this course?\')" title="Delete"><i class="fa fa-trash"></i></button></form>';
                $btn .= '</div>';
                return $btn;
            })
            ->editColumn('description', function($row) {
                return \Illuminate\Support\Str::limit($row->description, 50);
            })
            ->editColumn('duration', function($row) {
                return '<span class="badge bg-secondary">'.($row->duration ?? 'N/A').'</span>';
            })
            ->editColumn('price', function($row) {
                return number_format($row->price, 2);
            })
            ->rawColumns(['action', 'duration'])
            ->make(true);
    }

    public function createCourse(array $data)
    {
        return Course::create($data);
    }

    public function updateCourse(Course $course, array $data)
    {
        return $course->update($data);
    }

    public function deleteCourse(Course $course)
    {
        return $course->delete();
    }
}
