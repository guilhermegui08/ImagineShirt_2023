<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|size:6',
            'name' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'This field is mandatory',
            'code.required' => 'This field is mandatory',
            'code.size' => 'Color code must be a hex code (6 characters)',
        ];
    }
}
