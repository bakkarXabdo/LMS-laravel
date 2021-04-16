<?php

namespace App\Rules;

use App\Models\BookCopy;
use Illuminate\Contracts\Validation\Rule;

class UniqueCopy implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($currentKey)
    {
        $this->currentKey = $currentKey;
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
        $q = BookCopy::where(BookCopy::KEY, $value);
        if(!empty($this->currentKey))
        {
            $q->where(BookCopy::KEY, '!=', $this->currentKey);
        }
        return !$q->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "الشفرة :input مستعملة ";
    }
}
