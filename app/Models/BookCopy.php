<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BookCopy
 *
 * @property string $Id
 * @property string|null $InventoryId
 * @property string $BookId
 * @property \Illuminate\Support\Carbon $UpdatedAt
 * @property-read \App\Models\Book $book
 * @property-read int $copy_number
 * @property-read \App\Models\Rental|null $rental
 * @method static Builder|BookCopy newModelQuery()
 * @method static Builder|BookCopy newQuery()
 * @method static Builder|BookCopy query()
 * @method static Builder|BookCopy whereBookId($value)
 * @method static Builder|BookCopy whereId($value)
 * @method static Builder|BookCopy whereInventoryId($value)
 * @method static Builder|BookCopy whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BookCopy extends Model
{
    use ModelTraits;

    public const TABLE = "bookcopies";
    public const KEY = "Id";
    public const FOREIGN_KEY = "BookCopyId";
    public const CREATED_AT = "CreatedAt";
    public const UPDATED_AT = null;
    public const TABLE_DOT_KEY = self::TABLE . "." . self::KEY;

    protected $table = self::TABLE;
    protected $primaryKey = self::KEY;
    protected $keyType = "string";
    public $incrementing = false;
    protected $guarded = [];

    function book(){
        return $this->belongsTo(Book::class);
    }

    function rental(){
        return $this->hasOne(Rental::class);
    }

    public function getCopyNumberAttribute(): int
    {
        return (int) preg_replace('/^[A-Za-z]+\\/\d+\\//', '', $this->getKey());
    }

    public static function getIdPattern(): string
    {
        return '^[A-Za-z]+\/\d+\/\d+$';
    }

    public function getEncodedKeyAttribute() : string
    {
        return urlencode($this->getKey());
    }
}
