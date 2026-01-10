<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class FeeStructureStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'class_name_select' => 'required|string',
            'fee_head' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'fee_type' => 'required|in:Monthly,Quarterly,Half-Yearly,Yearly,One-Time',
            'frequency' => 'required|in:One-Time,Monthly,Quarterly,Yearly',
            'is_mandatory' => 'boolean',
            'description' => 'nullable|string',
        ];
    }
}
