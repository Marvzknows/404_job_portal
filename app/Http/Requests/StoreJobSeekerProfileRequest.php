<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobSeekerProfileRequest extends FormRequest
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
            'bio' => 'required|string|min:8|max:255',
            'portfolio' => 'required|string|min:8|max:255',
            'current_job_title' => 'required|string|min:8|max:255',
            'resume' => 'required|file|mimes:pdf|max:2048',
            'phone' => 'required|string|max:20|min:11',
            'location' => 'required|string|max:255|min:8',
        ];
    }
}
