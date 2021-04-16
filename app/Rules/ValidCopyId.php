<?php

namespace App\Rules;

use App\Models\BookCopy;
use Illuminate\Contracts\Validation\Rule;

class ValidCopyId implements Rule
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
        return preg_match('/'.BookCopy::getIdPattern().'/', $value, $macthes);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "الشفرة غير صحيحه, يجب أن تكون من الشكل XXX/000/000";
    }
}
