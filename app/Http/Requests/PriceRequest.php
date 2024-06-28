<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
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
            'unit_price_catalog' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'unit_price_own' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'unit_price_catalog_discount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'unit_price_own_discount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'qty_discount' => 'required|integer|gte:0',
        ];
    }

    public function messages(): array
    {
        return [
            'unit_price_catalog.required' => 'This field is mandatory',
            'unit_price_own.required' => 'This field is mandatory',
            'unit_price_catalog_discount.required' => 'This field is mandatory',
            'unit_price_own_discount.required' => 'This field is mandatory',
            'qty_discount.required' => 'This field is mandatory',

//            'unit_price_catalog.numeric' => 'Price must be a numeric value',
//            'unit_price_own.numeric' => 'Price must be a numeric value',
//            'unit_price_catalog_discount.numeric' => 'Price must be a numeric value',
//            'unit_price_own_discount.numeric' => 'Price must be a numeric value',
//            'qty_discount.integer' => 'Quantity must be a numeric value',

            'unit_price_catalog.regex' => 'Invalid value for price',
            'unit_price_own.regex' => 'Invalid value for price',
            'unit_price_catalog_discount.regex' => 'Invalid value for price',
            'unit_price_own_discount.regex' => 'Invalid value for price',
            'qty_discount.gte' => 'Quantity must be a positive value',
        ];
    }
}
