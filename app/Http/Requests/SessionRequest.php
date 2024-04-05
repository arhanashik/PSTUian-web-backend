<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class SessionRequest extends FormRequest
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
        $SessionId = $this->route('session');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'][] = Rule::unique('sessions')->ignore($SessionId);
        } else {
            $rules['name'][] = 'unique:sessions,name';
        }

        return $rules;
    }
}
