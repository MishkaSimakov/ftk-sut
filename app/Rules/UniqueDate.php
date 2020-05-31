<?php

namespace App\Rules;

use App\Rating;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class UniqueDate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_numeric($value)) {
            return !Rating::whereDate('date', now()->setYear($value + 1)->setMonth(5)->endOfMonth())->exists();
        } else {
            return !Rating::whereDate('date', Carbon::parse($value))->exists();
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Рейтинг с такой датой уже существует';
    }
}
