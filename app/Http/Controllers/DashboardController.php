<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'students' => Student::count(),
            'courses' => Course::count(),
            'recentStudents' => Student::latest()->take(5)->get(),
        ];

        return view('dashboard', $stats);
    }
}
