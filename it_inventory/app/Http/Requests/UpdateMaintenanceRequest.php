<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:open,in_progress,resolved'],
            'description' => ['required', 'string'],
            'cost' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
