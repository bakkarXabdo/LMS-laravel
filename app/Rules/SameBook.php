<?php

namespace App\Rules;

use App\Helpers\AppHelper;
use Illuminate\Contracts\Validation\Rule;

class SameBook implements Rule
{

    private $isValid;
    private $originalBook;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($original, $new)
    {
        $this->originalBook = strtoupper(preg_replace('/[^0-9A-Za-z]\d+$/', '', $original));
        $this->isValid = $this->originalBook === strtoupper(preg_replace('/[^0-9A-Za-z]\d+$/', '', $new));
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
        return $this->isValid;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return AppHelper::ArabicFormat("لا يمكنك تغيير كتاب النسخة, الكتاب الأصلي:؟", $this->originalBook);
    }
}
