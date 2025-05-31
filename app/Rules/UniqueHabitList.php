<?php

namespace App\Rules;

use App\Models\HabitList;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class UniqueHabitList implements ValidationRule
{
    private $id;

    public function __construct($id=null){
        $this->id = $id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (HabitList::where('name', Str::squish($value))
            ->when($this->id, fn($query) => $query->where('id', '!=', $this->id))
            ->exists()
        ) {
            $fail("This {$attribute} already exists. Try another one.");
        }
    }
}
