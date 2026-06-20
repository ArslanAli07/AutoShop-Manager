<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreIntakeRequest extends FormRequest
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
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:1000',

            'plate_number' => 'required|string|max:20',
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'nullable|integer|min:1900|max:2099',

            'mileage_in' => 'nullable|integer|min:0',
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
