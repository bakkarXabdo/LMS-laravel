<?php

namespace App\Rules;

use App\Models\BookLanguage;
use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\ValidationException;

class HasValidInventoryNumber implements Rule
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
    public function passes($attribute, $id)
    {
        preg_match('/^[A-Za-z]+\//', $id, $match);
        if(empty($match[0]))
        {
            return false;
        }
        preg_match('/\d+$/', $id, $match);
        if(empty($match[0]))
        {
            return false;
        }
        return strlen(preg_replace('/[^\/]/', '', $id)) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'شفرة الكتاب (:input) غير صحية ,يجب أن تكون من الشكل: AAA/000';
    }
}
