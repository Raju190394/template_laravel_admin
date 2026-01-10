<?php

namespace App\Services;

use App\Models\FeePayment;
use Illuminate\Support\Str;

class FeeService
{
    public function recordPayment(array $data)
    {
        // Generate a unique receipt number
        $data['receipt_no'] = 'RCPT-' . strtoupper(Str::random(8));

        return FeePayment::create($data);
    }

    public function getStudentFeeStructures(\App\Models\Student $student)
    {
        $class = $student->class;
        
        if (!$class) {
            return collect();
        }

        $className = $class->class_name;
        $classIds = \App\Models\Classes::where('class_name', $className)->pluck('id');

        return \App\Models\FeeStructure::whereIn('class_id', $classIds)->get();
    }
}
