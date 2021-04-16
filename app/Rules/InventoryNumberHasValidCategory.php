<?php

namespace App\Rules;

use App\Helpers\AppHelper;
use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class InventoryNumberHasValidCategory implements Rule
{

    /**
     * stores the category part of the bookid
     *
     * @var string
     */
    private $categoryCode;


    /**
     * stores the caegory of the book
     *
     * @var Category
     */
    private $category;


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
        preg_match('/^[A-Za-z]+/', $bookId, $match);
        if(!empty($match[0]) && !is_array($match[0]))
        {
            $this->categoryCode = substr($match[0], 0, -1);
            $this->category = Category::where('code', $this->categoryCode)->first();
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
        return $this->category && $this->category->exists;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return AppHelper::ArabicFormat("فئة الكتاب ؟ غير معروفة في الشفرة ؟, الرجاء إدخال فئة جديدة بالرمز ؟",[
            $this->categoryCode,
            $this->bookId,
            $this->categoryCode
        ]);
    }

    public function getCategory()
    {
        return $this->category;
    }
}
