<?php

namespace App\Rules;

use App\Models\Book;
use Illuminate\Contracts\Validation\Rule;

class UniqueBook implements Rule
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
        $q = Book::where(Book::KEY, $value);
        if(!empty($this->currentKey))
        {
            $q->where(Book::KEY, '!=', $this->currentKey);
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
