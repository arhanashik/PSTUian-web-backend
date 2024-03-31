<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'short_title' => ['required', 'string', 'max:50', 'alpha'],
            'title' => ['required', 'string', 'max:150', 'alpha'],            
        ];
    }
    public function messages(): array
    {
        return [
            'short_title.required' => 'The short title field is required.',
            'short_title.string' => 'The short title must be a string.',
            'short_title.max' => 'The short title may not be greater than :max characters.',
            'short_title.alpha' => 'The short title may only contain alphabetic characters.',

            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than :max characters.',
            'title.alpha' => 'The title may only contain alphabetic characters.',           
        ];
    }
}
