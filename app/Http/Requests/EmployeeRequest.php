<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
            ],
            'designation' => [
                'required',
                'string',
                'max:255',
            ],
            'department' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('employees')->ignore($this->employee),
            ],
            'address' => [
                'required',
                'string',
                'max:255',
            ],
            'image_url' => [
                'required',
                'string',
                'max:255',
            ],
            'faculty_id' => [
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
            'designation.required' => 'Designation field is required.',
            'designation.string' => 'Designation must be a string.',
            'designation.max' => 'Designation may not be greater than :max characters.',
            'department.required' => 'Department field is required.',
            'department.string' => 'Department must be a string.',
            'department.max' => 'Department may not be greater than :max characters.',
            'phone.required' => 'Phone field is required.',
            'phone.string' => 'Phone must be a string.',
            'phone.max' => 'Phone may not be greater than :max characters.',
            'phone.unique' => 'Phone number must be unique.',
            'address.required' => 'Address field is required.',
            'address.string' => 'Address must be a string.',
            'address.max' => 'Address may not be greater than :max characters.',
            'image_url.required' => 'Image URL field is required.',
            'image_url.string' => 'Image URL must be a string.',
            'image_url.max' => 'Image URL may not be greater than :max characters.',
            'faculty_id.required' => 'Faculty ID field is required.',
            'faculty_id.integer' => 'Faculty ID must be an integer.',
        ];
    }
}