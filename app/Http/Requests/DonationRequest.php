<?php

declare(strict_types=1);

namespace App\Http\Requests;

class DonationRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:100'],
            'info' => ['nullable', 'string', 'max:500'],
            'email' => ['nullable', 'string', 'email', 'max:150'],
            'reference' => ['required', 'string', 'max:150'],
        ];
    }
}
