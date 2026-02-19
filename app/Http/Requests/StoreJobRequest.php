<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|json',
            'salary_min' => 'required|numeric|min:0',
            'salary_max' => 'required|numeric|min:0|gte:salary_min',
            'work_setup' => 'required|in:remote,on_site,hybrid',
            'job_type' => 'required|in:full_time,part_time,contract,internship',
        ];
    }

    public function messages(): array
    {
        return [
            'description.json' => 'Description must be a valid JSON string.',
            'salary_min.numeric' => 'Minimum salary must be a number.',
            'salary_min.min' => 'Minimum salary must be at least 0.',
            'salary_max.numeric' => 'Maximum salary must be a number.',
            'salary_max.min' => 'Maximum salary must be at least 0.',
            'salary_max.gte' => 'Maximum salary must be greater than or equal to minimum salary.',
            'work_setup.in' => 'Work setup must be one of the following: remote, on_site, hybrid.',
            'job_type.in' => 'Job type must be one of the following: full_time, part_time, contract, internship.',
        ];
    }
}
