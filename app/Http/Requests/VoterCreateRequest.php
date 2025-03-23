<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoterCreateRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'last_name' => ['required', 'string', 'min:1', 'max:255'],
            'document' => ['required', 'string', 'min:8', 'max:8', 'unique:voters'],
            'dob' => ['required', 'date_format:Y-m-d'],
            'address' => ['required', 'string', 'min:1', 'max:255'],
            'phone' => ['required', 'string', 'min:1', 'max:255'],
            'gender' => ['required', 'string', 'in:male,female,other']
        ];
    }
}
