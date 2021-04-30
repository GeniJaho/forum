<?php

namespace App\Rules;

use App\Inspections\Spam;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class SpamFree implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        try {
            return ! app(Spam::class)->detect($value);
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute contains spam.';
    }
}
