<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'id' => ['required', 'integer', 'min:1'],
            'name' => ['string', 'min:1', 'max:255'],
            'email' => ['email', 'unique:users'],
            'password'=> ['string', 'min:8', 'max:16', 'regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[`!@#$%&*()_{};:,.<>?~])([a-zA-Z0-9`!@#$%&*()_{};:,.<>?~]){8,}$/'],
            'role' => ['string', 'in:admin,client']
        ];
    }
}
