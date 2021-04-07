<?php

namespace App\Rules;

use App\Models\BookLanguage;
use Illuminate\Contracts\Validation\Rule;

class InventoryNumberHasValidLanguage implements Rule
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
        preg_match('/^[A-Za-z]+/', $id, $match);
        $id = $match[0];
        if(empty($id))
        {
            return false;
        }
        $code = substr($id, strlen($id)-1);
        return BookLanguage::where('code', $code)->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'لغة الكتاب غير معروفة في الشفرة :input';
    }
}
