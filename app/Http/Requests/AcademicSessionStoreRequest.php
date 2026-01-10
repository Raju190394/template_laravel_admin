<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicSessionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('academic_session') ? $this->route('academic_session')->id : null;
        return [
            'name' => 'required|string|unique:academic_sessions,name,' . $id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }
}
