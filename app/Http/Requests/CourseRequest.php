<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
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
            'course_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('courses')->ignore($this->course),
            ],
            'course_title' => [
                'required',
                'string',
                'max:100',
                Rule::unique('courses')->ignore($this->course),
            ],
            'credit_hour' => [
                'required',
                'string',
                'max:20'
            ],
            'faculty_id' => [
                'required'
            ],
        ];
    }
}
