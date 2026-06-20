<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'car_id' => 'required|exists:cars,id',
            'date_in' => 'required|date',
            'date_out' => 'nullable|date|after_or_equal:date_in',
            'mileage_in' => 'nullable|numeric|min:0',
            'mileage_out' => 'nullable|numeric|min:0',
            'status' => 'required|in:received,in_progress,ready,delivered,cancelled',
            'payment_status' => 'required|in:paid,unpaid,partial',
            'amount_paid' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'services' => 'nullable|array',
            'services.*.service_preset_id' => 'nullable|exists:service_presets,id',
            'services.*.description' => 'nullable|string|max:255',
            'services.*.labor_cost' => 'required|numeric|min:0',
            'parts' => 'nullable|array',
            'parts.*.parts_reference_id' => 'nullable|exists:parts_reference,id',
            'parts.*.part_name' => 'nullable|string|max:100',
            'parts.*.quantity' => 'required|numeric|min:0.01',
            'parts.*.unit_price' => 'required|numeric|min:0',
        ];
    }
}
