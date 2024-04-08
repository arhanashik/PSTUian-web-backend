<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class BatchRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('batches')->ignore($this->batche),
            ],
            'title' => [
                'string',
                Rule::unique('batches')->ignore($this->batche),
            ],
            'academicyear_id' => [
                'required',
                'integer',
            ],
            'faculty_id' => [
                'required',
                'integer',
            ],
            'total_student' => [
                'required',
                'integer',
            ],
        ];
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name field is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name may not be greater than :max characters.',
            'name.alpha' => 'Name may only contain alphabetic characters.',
            'title.string' => 'Title must be a string.',
            'title.max' => 'Title may not be greater than :max characters.',
            'title.alpha' => 'Title may only contain alphabetic characters.',
            'academicyear_id.required' => 'Academic year field is required.',
            'total_student.required' => 'Short title field is required.',
            'total_student.integer' => 'Total student must be an integer.',
        ];
    }
}
