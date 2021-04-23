<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Mod;

/**
 * App\Models\Category
 *
 * @mixin Builder
 * @property int $Id
 * @property string $Code
 * @property string $Name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCode($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 */
class Category extends Model
{
    use ModelTraits;

    public const TABLE = "categories";
    public const KEY = "Id";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::KEY;

    public const FOREIGN_KEY = "CategoryId";
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
