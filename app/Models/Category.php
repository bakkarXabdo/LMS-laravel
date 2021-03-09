<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    use HasFactory;
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
        return $this->belongsToMany(Book::class,
            self::FOREIGN_KEY,
            Book::FOREIGN_KEY,
            self::KEY,
            Book::KEY,
            Book::TABLE);
    }
}
