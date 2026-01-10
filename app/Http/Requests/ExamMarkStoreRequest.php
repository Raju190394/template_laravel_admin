<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamMarkStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $exam_schedule = $this->route('exam_schedule');
        return [
            'marks' => 'required|array',
            'marks.*' => 'nullable|numeric|min:0|max:'.$exam_schedule->full_marks,
            'absent' => 'nullable|array',
            'remarks' => 'nullable|array',
        ];
    }
}
