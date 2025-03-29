<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TripRequest extends FormRequest
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
            'trip_name' => 'required|string',
            'bus_id' => 'nullable|exists:buses,id',
            'pickup_station_id' => 'required|exists:stations,id',
            'dropoff_station_id' => 'required|exists:stations,id',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'deputre_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'avalible_seats' => 'required|integer|min:1',
            'country_id' => 'required|exists:countries,id',
            'to_country_id' => 'required|exists:countries,id',
            'to_city_id' => 'required|exists:cities,id',
            'to_zone_id' => 'required|exists:zones,id',
            'date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'max_book_date' => 'nullable|date',
            'type' => 'nullable|in:limited,unlimited',
            'fixed_date' => 'nullable|date',
            'cancellation_policy' => 'nullable|string',
            'cancelation_pay_amount' => 'nullable|in:fixed,percentage',
            'cancelation_pay_value' => 'nullable|numeric|min:0',
            'min_cost' => 'nullable|numeric|min:0',
            'trip_type' => 'required|in:bus,hiace,train',
            'currency_id' => 'required|exists:currencies,id',
            'cancelation_date' => 'nullable|date',
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
