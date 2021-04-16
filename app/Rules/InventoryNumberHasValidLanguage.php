<?php

namespace App\Rules;

use App\Helpers\AppHelper;
use App\Models\BookLanguage;
use Illuminate\Contracts\Validation\Rule;

class InventoryNumberHasValidLanguage implements Rule
{
    /**
     * stores the langauge part of the bookid
     *
     * @var string
     */
    private $languageCode;


    /**
     * stores the langauge of the book
     *
     * @var BookLanguage
     */
    private $language;


    /**
     * stores the original bookid string
     *
     * @var string
     */
    private $bookId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public function __construct($bookId)
    {
        $this->bookId = $bookId;
        $this->languageCode = null;
        preg_match('/^[A-Za-z]+/', $bookId, $match);
        if(!empty($match[0]) && !is_array($match[0]))
        {
            $this->languageCode = substr($match[0], strlen($match[0])-1);
            $this->language = BookLanguage::where('code', $this->languageCode)->first();
        }

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
        return $this->language && $this->language->exists;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return AppHelper::ArabicFormat("لغة الكتاب ؟ غير معروفة في الشفرة ؟, الرجاء إدخال لغة جديدة بالرمز ؟",[
            $this->languageCode,
            $this->bookId,
            $this->languageCode
        ]);
    }

    public function getLanguage()
    {
        return $this->language;
    }
}
