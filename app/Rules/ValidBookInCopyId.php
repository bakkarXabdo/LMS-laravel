<?php

namespace App\Rules;

use App\Helpers\AppHelper;
use App\Models\Book;
use Illuminate\Contracts\Validation\Rule;

class ValidBookInCopyId implements Rule
{
    /**
     * stores the bookid part of the copyid
     *
     * @var string
     */
    private $bookId;

    /**
     * stores the book of the bookcopy
     *
     * @var Book
     */
    private $book;


    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($value)
    {
        $this->bookId = preg_replace('/[^0-9A-Za-z]\d+$/', '', $value);
        $this->book = Book::find($this->bookId);
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
        return $this->book && $this->book->exists;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return AppHelper::ArabicFormat("الكتاب ؟ غير موجود", $this->bookId);
    }
    public function getBook()
    {
        return $this->book;
    }
}
