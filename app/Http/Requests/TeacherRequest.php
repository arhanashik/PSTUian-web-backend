<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
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
            't_id' => [
                'required',
                'numeric',
                Rule::unique('teachers')->ignore($this->teacher),
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
                Rule::unique('teachers')->ignore($this->teacher),
            ],
            'reg' => [
                'required',
                'numeric',
                Rule::unique('teachers')->ignore($this->teacher),
            ],
            'faculty_id' => [
                'required'
            ],
            'department_id' => [
                'required'
            ],
            'phone' => 'nullable|string|regex:/^[0-9]{10,20}$/',
            'website' => 'nullable|url',
            'linkedin' => [
                Rule::unique('teachers')->ignore($this->teacher),
            ],
            'facebook' => [
                Rule::unique('teachers')->ignore($this->teacher),
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
