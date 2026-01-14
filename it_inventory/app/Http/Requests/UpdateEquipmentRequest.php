<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipmentRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'serial_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('equipments', 'serial_number')->ignore($this->route('equipment')),
            ],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', 'in:available,assigned,broken,scrapped'],
            'purchase_date' => ['required', 'date'],
            'warranty_duration' => ['required', 'integer', 'min:0', 'max:120'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'details' => ['nullable', 'array'],
        ];
    }
}
