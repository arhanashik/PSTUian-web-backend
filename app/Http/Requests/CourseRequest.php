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
        $courseId = $this->route('course');
        $rules = [
            'course_code' => [
                'required',
                'string',
                'max:20'
            ],
            'course_title' => [
                'required',
                'string',
                'max:100'
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

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['course_code'][] = Rule::unique('courses')->ignore($courseId);
            $rules['course_title'][] = Rule::unique('courses')->ignore($courseId);
        } else {
            $rules['course_code'][] = 'unique:courses,course_code';
            $rules['course_title'][] = 'unique:courses,course_title';
        }

        return $rules;
    }
}
