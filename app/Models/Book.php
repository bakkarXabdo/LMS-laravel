<?php

namespace App\Models;

use App\Models\Traits\HasHistory;
use App\Models\Traits\HasRentals;
use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Book
 *
 * @mixin Builder
 * @property string $InventoryNumber
 * @property string $Title
 * @property string $Author
 * @property string $Publisher
 * @property string|null $ReleaseYear
 * @property int $NumberOfCopies
 * @property int $Price
 * @property float $Popularity
 * @property int $CategoryId
 * @property int $LanguageId
 * @property int $TotalRentals
 * @property string $EncodedKey
 * @property string $Isbn
 * @property \Illuminate\Support\Carbon $DateAdded
 * @property \Illuminate\Support\Carbon $UpdatedAt
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookCopy[] $copies
 * @property-read int|null $copies_count
 * @property-read mixed $number_available
 * @property-read mixed $number_in_stock
 * @property-read mixed $path
 * @property-read int|null $rentals_count
 * @property-read \App\Models\BookLanguage|null $language
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rental[] $rentals
 * @method static Builder|Book newModelQuery()
 * @method static Builder|Book newQuery()
 * @method static Builder|Book query()
 * @method static Builder|Book whereAuthor($value)
 * @method static Builder|Book whereCategoryId($value)
 * @method static Builder|Book whereDateAdded($value)
 * @method static Builder|Book whereInventoryNumber($value)
 * @method static Builder|Book whereIsbn($value)
 * @method static Builder|Book whereLanguageId($value)
 * @method static Builder|Book whereNumberOfCopies($value)
 * @method static Builder|Book wherePopularity($value)
 * @method static Builder|Book wherePrice($value)
 * @method static Builder|Book wherePublisher($value)
 * @method static Builder|Book whereReleaseYear($value)
 * @method static Builder|Book whereTitle($value)
 * @method static Builder|Book whereTotalRentals($value)
 * @method static Builder|Book whereUpdatedAt($value)
 * @method static Book findOrFail($value)
 */

class Book extends Model
{
    use ModelTraits, HasHistory, HasRentals;
    public const TABLE = "books";
    public const KEY = "InventoryNumber";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::KEY;
    public const FOREIGN_KEY = "BookId";
    public const CREATED_AT = "DateAdded";
    public const UPDATED_AT = "UpdatedAt";

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

    /**-- Attributes --*/

    function getPathAttribute(){
        return route('books.show', $this->getKey());
    }
    function getRentalsCountAttribute(){
        return $this->rentals()->count();
    }
    function getNumberInStockAttribute(){
        return $this->copies()->count();
    }
    function getNumberAvailableAttribute(){
        return $this->numberInStock - $this->rentalsCount;
    }

    /**-- DB RELATIONS --*/

    function language(){
        return $this->belongsTo(BookLanguage::class);
    }
    function category(){
        return $this->belongsTo(Category::class);
    }
    function copies(){
        return $this->hasMany(BookCopy::class);
    }

    public static function getIdPattern(): string
    {
        return '^[A-Za-z]+\/\d+$';
    }
    public static function getIncludedIdPattern(): string
    {
        return '^[A-Za-z]+\/\d+';
    }
    // public function getEncodedKeyAttribute() : string
    // {
    //     return urlencode($this->getKey());
    // }

    public function firstAvailableCopy()
    {
        return $this->copies()->whereDoesntHave('rental')->first();
    }

    public static function fromCopyIdOrFail($copyId)
    {
        return Book::findOrFail(preg_replace('/[^0-9A-Za-z]\d+$/', '', $copyId));
    }


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
        preg_match('/\/\d+$/', $this->getKey(), $matches);
        return $matches[0];
    }


}
