<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidUruguayanCedula;

class VoterUpdateRequest extends FormRequest
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
            'last_name' => ['string', 'min:1', 'max:255'],
            'document' => ['string', 'min:8', 'max:8', new ValidUruguayanCedula(), 'unique:voters,document,' . $this->id],
            'dob' => ['date_format:Y-m-d'],
            'address' => ['string', 'min:1', 'max:255'],
            'phone' => ['string', 'min:1', 'max:255'],
            'gender' => ['string', 'in:male,female,other']
        ];
    }
}
