<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Rental
 *
 * @mixin Builder
 * @property int $Id
 * @property int $StudentId
 * @property string $BookId
 * @property string $BookCopyId
 * @property Carbon $ExpiresAt
 * @property \Illuminate\Support\Carbon $CreatedAt
 * @property-read \App\Models\Book $book
 * @property-read \App\Models\BookCopy $copy
 * @property-read mixed $return_date
 * @property-read \App\Models\Student $student
 * @method static Builder|Rental newModelQuery()
 * @method static Builder|Rental newQuery()
 * @method static Builder|Rental query()
 * @method static Builder|Rental whereBookCopyId($value)
 * @method static Builder|Rental whereBookId($value)
 * @method static Builder|Rental whereCreatedAt($value)
 * @method static Builder|Rental whereExpiresAt($value)
 * @method static Builder|Rental whereId($value)
 * @method static Builder|Rental whereStudentId($value)
 */
class Rental extends Model
{
    use ModelTraits;

    public const TABLE = "rentals";
    public const KEY = "Id";
    public const FOREIGN_KEY = "RentalId";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::KEY;

    public const CREATED_AT = "CreatedAt";
    public const UPDATED_AT = null;
    public $casts = [
        "ExpiresAt" => "datetime"
    ];
    /**-- DB RELATIONS --*/

    protected $table = self::TABLE;
    protected $primaryKey = self::KEY;
    protected $guarded = [self::KEY];

    function student(){
        return $this->belongsTo(Student::class, Student::FOREIGN_KEY, Student::KEY);
    }

    function book(){
        return $this->belongsTo(Book::class, Book::FOREIGN_KEY, Book::KEY);
    }

    function copy(){
        return $this->belongsTo(BookCopy::class, BookCopy::FOREIGN_KEY, BookCopy::KEY);
    }
    function getRemainingDaysAttribute()
    {
        $now = Carbon::now();
        $diff =  $this->ExpiresAt->diffInDays($now);
        if($this->ExpiresAt->lessThan($now)){
            $diff = -1 * $diff;
        }
        return $diff;
    }
}
