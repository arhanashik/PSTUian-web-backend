<?php

declare(strict_types=1);

namespace App\Http\Requests;

class RequestBloodDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'blood_group' => [
                'required',
                'string',
                'max:20'
            ],
            'need_before' => [
                'required',
                'date'
            ],
            'phone' => [
                'required',
                'numeric',
                'digits_between:1,11'
            ],
            'message' => [
                'required',
                'string',
                'max:400'
            ],
        ];
        
    }
}
