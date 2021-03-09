<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Rental
 *
 * @mixin Builder
 * @property int $Id
 * @property int $StudentId
 * @property string $BookId
 * @property string $BookCopyId
 * @property string $ExpiresAt
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
    use HasFactory;
    public const TABLE = "rentals";
    public const KEY = "Id";
    public const FOREIGN_KEY = "RentalId";
    public const TABLE_DOT_KEY = self::TABLE . "." . self::KEY;

    public const CREATED_AT = "CreatedAt";
    public const UPDATED_AT = null;

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
    function getReturnDateAttribute()
    {
        $diff =  Carbon::parse($this->attributes['Expires'])->diffInDays(Carbon::now());
        if(Carbon::parse($this->attributes['Expires'])->lessThan(Carbon::now())){
            $diff = -1 * $diff;
        }
        return (int)$diff;
    }

    public static function joinWithSelf(Builder $query) : Builder
    {
        $with = $query->getModel();
        return $query->join(self::TABLE, $with::TABLE . "." . self::FOREIGN_KEY, '=', self::TABLE . "." . self::KEY);
    }
}
