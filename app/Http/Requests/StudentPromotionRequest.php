<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentPromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_session_id' => 'required|exists:academic_sessions,id',
            'target_session_id' => 'required|exists:academic_sessions,id|different:current_session_id',
            'current_class_id' => 'required|exists:classes,id',
            'target_class_id' => 'required|exists:classes,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ];
    }
}
