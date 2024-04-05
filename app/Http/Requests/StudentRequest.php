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
        $StudentId = $this->route('student');
        $rules = [
            's_id' => [
                'required',
                'integer'
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
                'max:100', // adjust the max length as needed
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'reg' => [
                'required',
                'integer'
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

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['s_id'][] = Rule::unique('students')->ignore($StudentId);
            $rules['name'][] = Rule::unique('students')->ignore($StudentId);
            $rules['reg'][] = Rule::unique('students')->ignore($StudentId);
        } else {
            $rules['s_id'][] = 'unique:students,id';
            $rules['name'][] = 'unique:students,name';
            $rules['reg'][] = 'unique:students,reg';
        }

        return $rules;
    }
    
}
