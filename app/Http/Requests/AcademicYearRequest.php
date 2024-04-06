<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AcademicYearRequest extends FormRequest
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
        $AcademicYearId = $this->route('academicyear');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'][] = Rule::unique('academic_years')->ignore($AcademicYearId);
        } else {
            $rules['name'][] = 'unique:academic_years,name';
        }

        return $rules;
    }
}
