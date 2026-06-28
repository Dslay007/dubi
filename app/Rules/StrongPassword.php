<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * Password harus mengandung:
     * - Minimal 8 karakter
     * - Minimal 1 huruf kapital (A-Z)
     * - Minimal 1 huruf kecil (a-z)
     * - Minimal 1 angka (0-9)
     * - Minimal 1 karakter spesial (!@#$%^&*()_+-=[]{}|;:',.<>?/`~")
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) < 8) {
            $fail('Password harus minimal 8 karakter.');
            return;
        }

        if (!preg_match('/[A-Z]/', $value)) {
            $fail('Password harus mengandung minimal 1 huruf kapital (A-Z).');
            return;
        }

        if (!preg_match('/[a-z]/', $value)) {
            $fail('Password harus mengandung minimal 1 huruf kecil (a-z).');
            return;
        }

        if (!preg_match('/[0-9]/', $value)) {
            $fail('Password harus mengandung minimal 1 angka (0-9).');
            return;
        }

        if (!preg_match('/[!@#$%^&*()_+\-=\[\]{}|;:\'",.<>?\\/`~\\\\]/', $value)) {
            $fail('Password harus mengandung minimal 1 karakter spesial (!@#$%^&* dll).');
            return;
        }
    }
}
