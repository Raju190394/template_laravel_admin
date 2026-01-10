<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamScheduleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $exam = $this->route('exam');
        return [
            'class_id' => 'required|exists:classes,id',
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date|after_or_equal:'.$exam->start_date.'|before_or_equal:'.$exam->end_date,
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'full_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|lt:full_marks',
            'room_no' => 'nullable|string'
        ];
    }
}
