<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidUruguayanCedula implements ValidationRule
{
    /**
     * Validate the Cédula de Identidad Uruguaya.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove non-numeric characters
        $cedula = preg_replace('/[^\d]/', '', $value);

        // Must be exactly 8 digits
        if(strlen($cedula) !== 8) {
            $fail('The document field must be exactly 8 digits.');
            return;
        }

        // Split base number and check digit
        $base = substr($cedula, 0, 7);
        $checkDigit = (int) substr($cedula, 7, 1);

        // Weights for the calculation
        $weights = [2, 9, 8, 7, 6, 3, 4];
        $sum = 0;

        // Apply the Module 10 algorithm
        for($i = 0; $i < 7; $i++) {
            $sum += (int) $base[$i] * $weights[$i];
        }

        // Compute the check digit
        $computedCheckDigit = (10 - ($sum % 10)) % 10;

        // Validate check digit
        if($computedCheckDigit !== $checkDigit) {
            $fail('The document is not a valid Uruguayan cedula.');
        }
    }
}
