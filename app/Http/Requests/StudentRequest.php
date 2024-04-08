<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
        $rules = [
            's_id' => [
                'required',
                'integer',
                Rule::unique('students')->ignore($this->student),
            ],
            'name' => [
                'required',
                'string',
                'max:50',
                'alpha',
                'regex:/^[a-zA-Z]+$/'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                Rule::unique('students')->ignore($this->student),
            ],
            'reg' => [
                'required',
                'integer',
                Rule::unique('students')->ignore($this->student),
            ],
            'faculty_id' => [
                'required'
            ],
            'batch_id' => [
                'required'
            ],
            'session_id' => [
                'required'
            ],
        ];

        return $rules;
    }
    
}
