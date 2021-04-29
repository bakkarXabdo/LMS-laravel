<?php

namespace App\Models;

use App\Models\Traits\HasHistory;
use App\Models\Traits\ModelTraits;
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
 * @method static Builder|BookCopy offset($value)
 * @method static BookCopy findOrFail($id)
 * @method static Student first($columns = ['*'])
 * @mixin Builder
 */
class BookCopy extends Model
{
    use ModelTraits, HasHistory;

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


    public static function booted()
    {
        self::creating(function($model){
            $model->setAttribute($model->getKeyName(), strtoupper($model->getKey()));
        });
        self::updating(function($model){
            $model->setAttribute($model->getKeyName(), strtoupper($model->getKey()));
        });
    }

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
    public function getPathAttribute()
    {
        return route('bookcopies.show', $this->getKey());
    }
    // public function getEncodedKeyAttribute() : string
    // {
    //     return urlencode($this->getKey());
    // }


    public function getLanguageCodeAttribute()
    {
        preg_match('/^[A-Za-z]+/', $this->getKey(), $matches);
        return substr($matches[0], strlen($matches[0])-1);
    }
    public function getCategoryCodeAttribute()
    {
        preg_match('/^[A-Za-z]+/', $this->getKey(), $matches);
        return substr($matches[0], 0, -1);
    }
    public function getNumericIdAttribute()
    {
        preg_match('/\/\d+\/\d+$/', $this->getKey(), $matches);
        return $matches[0];
    }


}
