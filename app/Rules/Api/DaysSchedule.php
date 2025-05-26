<?php

namespace App\Rules\Api;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DaysSchedule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (in_array('EVERY', $value) && count($value) > 1) {
            $fail("In {$attribute} you may not select 'EVERY' along with specific days.");
        }
    }
}
