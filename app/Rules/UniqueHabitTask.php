<?php

namespace App\Rules;

use App\Models\HabitTask;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class UniqueHabitTask implements ValidationRule
{
    private $id, $listId;

    public function __construct($listId=null, $id=null){
        $this->id     = $id;
        $this->listId = $listId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (HabitTask::where('name', Str::squish($value))
            ->when($this->id, fn($query) => $query->where('id', '!=', $this->id))
            ->where('habit_list_id', $this->listId)
            ->exists()
        ) {
            $fail("This {$attribute} already exists. Try another one.");
        }
    }
}
