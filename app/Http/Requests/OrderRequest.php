<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => [
                'sometimes',
                Rule::exists('users', 'id'),
            ],
            'status' => 'required|in:pending,paid,closed,canceled',

            'nif' => 'sometimes|string|digits:9',
            'date' => 'sometimes|date',
            'total_price' => 'sometimes|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'notes' => 'sometimes|string|',
            'address' => 'sometimes|string',
            'payment_type' => 'sometimes|in:VISA,MC,PAYPAL',
            'payment_ref' => 'sometimes|string',
        ];
    }
}

