<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PersonNameRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^[\p{L}\p{M}\s\'.\-]+$/u', $value)) {
            $fail(__('The :attribute may only contain letters, spaces, apostrophes, periods, and hyphens.'));
        }
    }
}
