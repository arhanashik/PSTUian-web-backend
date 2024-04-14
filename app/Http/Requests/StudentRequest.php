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
                'numeric',
                Rule::unique('students')->ignore($this->student),
            ],
            'name' => [
                'required',
                'string',
                'max:50',
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
                'numeric',
                Rule::unique('students')->ignore($this->student),
            ],
            'faculty_id' => [
                'required'
            ],
            'batche_id' => [
                'required'
            ],
            'academicyear_id' => [
                'required'
            ],
        ];


        if ($this->isMethod('patch')) {
            foreach ($rules as $field => &$fieldRules) {
                $fieldRules[] = 'sometimes';
            }
        }

        return $rules;
    }

}
