<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployerProfileRequest extends FormRequest
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
            'company_name' => 'required|string|max:255|min:3',
            'company_description' => 'required|string|max:255|min:8',
            'website' => 'nullable|string|max:255|min:8',
            'contact_email' => 'nullable|email|max:255|min:8',
            'contact_phone' => 'nullable|string|max:20|min:11',
            'location' => 'required|string|max:255|min:8',
        ];
    }
}
