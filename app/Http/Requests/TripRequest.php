<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
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
        if (request()->isMethod('PUT') || request()->isMethod('PATCH')) {
            return [
                'trip_name' => 'sometimes|string',
                'bus_id' => 'sometimes|exists:buses,id',
                'pickup_station_id' => 'sometimes|exists:stations,id',
                'dropoff_station_id' => 'sometimes|exists:stations,id',
                'city_id' => 'sometimes|exists:cities,id',
                'zone_id' => 'sometimes|exists:zones,id',
                'deputre_time' => 'sometimes',
                'arrival_time' => 'sometimes',
                'avalible_seats' => 'sometimes|integer|min:1',
                'country_id' => 'sometimes|exists:countries,id',
                'to_country_id' => 'sometimes|exists:countries,id',
                'to_city_id' => 'sometimes|exists:cities,id',
                'to_zone_id' => 'sometimes|exists:zones,id',
                'date' => 'nullable|date',
                'price' => 'sometimes|numeric|min:0',
                'status' => 'sometimes|in:active,inactive',
                'agent_id' => 'sometimes|exists:users,id',
                'max_book_date' => 'nullable|numeric|min:0',
                'type' => 'nullable|in:limited,unlimited',
                'fixed_date' => 'nullable|date',
                'cancellation_policy' => 'nullable|string',
                'cancelation_pay_amount' => 'nullable|in:fixed,percentage',
                'cancelation_pay_value' => 'nullable|numeric|min:0',
                'min_cost' => 'nullable|numeric|min:0',
                'trip_type' => 'sometimes|in:bus,hiace,train',
                'currency_id' => 'sometimes|exists:currencies,id',
                'cancelation_hours' => 'nullable|numeric',
                'day' => 'nullable|array',
                'day.*' => 'nullable|string|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
                'start_date' => 'nullable|date',
                'train_id' => 'nullable|exists:trains,id',
            ];
        }

        // Original validation rules for create
        return [
            'trip_name' => 'required|string',
            'bus_id' => 'required|exists:buses,id',
            'pickup_station_id' => 'required|exists:stations,id',
            'dropoff_station_id' => 'required|exists:stations,id',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'deputre_time' => 'required',
            'arrival_time' => 'required',
            'avalible_seats' => 'required|integer|min:1',
            'country_id' => 'required|exists:countries,id',
            'to_country_id' => 'required|exists:countries,id',
            'to_city_id' => 'required|exists:cities,id',
            'to_zone_id' => 'required|exists:zones,id',
            'date' => 'nullable|date',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'agent_id' => 'required|exists:users,id',
            'max_book_date' => 'nullable|numeric|min:0',
            'type' => 'nullable|in:limited,unlimited',
            'fixed_date' => 'nullable|date',
            'cancellation_policy' => 'nullable|string',
            'cancelation_pay_amount' => 'nullable|in:fixed,percentage',
            'cancelation_pay_value' => 'nullable|numeric|min:0',
            'min_cost' => 'nullable|numeric|min:0',
            'trip_type' => 'required|in:bus,hiace,train',
            'currency_id' => 'required|exists:currencies,id',
            'cancelation_hours' => 'nullable|numeric',
            'day' => 'nullable|array',
            'day.*' => 'nullable|string|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_date' => 'nullable|date',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ],400),);
    }
}
