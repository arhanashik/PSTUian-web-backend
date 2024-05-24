<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class BloodDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'user_type' => 'required|string|max:50',
            'request_id' => 'nullable|integer',
            'date' => 'required|date',
            'info' => 'nullable|string|max:500',
            'deleted' => 'required|integer',
        ];
        
    }
}
