<?php

declare(strict_types=1);

namespace App\Http\Requests;

class FacultyRequest extends FormRequest
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
            'short_title' => [
                'required',
                'string',
                'max:50',
                'alpha',
                'regex:/^[a-zA-Z]+$/'
            ],
            'title' => [
                'required',
                'string',
                'max:150',
            ],
        ];
    
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['short_title'][] = 'unique:faculties,short_title,' . $this->id;
            $rules['title'][] = 'unique:faculties,title,' . $this->id;
        } else {
            $rules['short_title'][] = 'unique:faculties,short_title';
            $rules['title'][] = 'unique:faculties,title';
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'short_title.required' => 'Short title field is required.',
            'short_title.string' => 'Short title must be a string.',
            'short_title.max' => 'Short title may not be greater than :max characters.',
            'short_title.alpha' => 'Short title may only contain alphabetic characters.',
            'title.required' => 'Title field is required.',
            'title.string' => 'Title must be a string.',
            'title.max' => 'Title may not be greater than :max characters.',
            'title.alpha' => 'Title may only contain alphabetic characters.',
            'short_title.unique_short_title' => 'The short title has already been taken.',
            'title.unique_title' => 'The title has already been taken.',
        ];
    }
}
