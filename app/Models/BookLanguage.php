<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BookLanguage
 *
 * @mixin Builder
 * @property int $Id
 * @property string $Code
 * @property string $Name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @method static Builder|BookLanguage newModelQuery()
 * @method static Builder|BookLanguage newQuery()
 * @method static Builder|BookLanguage query()
 * @method static Builder|BookLanguage whereCode($value)
 * @method static Builder|BookLanguage whereId($value)
 * @method static Builder|BookLanguage whereName($value)
 */
class BookLanguage extends Model
{
    use ModelTraits;
    public const TABLE = "languages";
    public const KEY = "Id";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::KEY;

    public const FOREIGN_KEY = "LanguageId";
    public const CREATED_AT = null;
    public const UPDATED_AT = null;

    /**-- DB RELATIONS --*/

    protected $table = self::TABLE;
    protected $primaryKey = self::KEY;
    protected $guarded = [];

    function books(){
        return $this->hasMany(Book::class);
        }
    public function copies()
    {
        return $this->hasManyThrough(BookCopy::class, Book::class);
    }
    public function rentals()
    {
        return $this->hasManyThrough(Rental::class, Book::class);
    }


}
