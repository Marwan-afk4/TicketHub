<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarRequest extends FormRequest
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
            // 
            'category_id' => ['required', 'exists:car_categories,id'],
            'brand_id' => ['required', 'exists:car_brands,id'],
            'model_id' => ['required', 'exists:car_models,id'],
            'car_number' => ['sometimes'],
            'car_color' => ['sometimes'],
            'car_year' => ['sometimes'],
            'status' => ['required', 'in:busy,available'],
            'capacity' => ['required', 'numeric'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ],400),);
    }
}
