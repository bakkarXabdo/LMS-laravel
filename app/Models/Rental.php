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
    /*
    let dayText;
    let late = days < 0 ? " متأخر ب" : 'متبقي';
    let dayClass = days <= 0 ? 'text-danger' : '';
    days = Math.abs(days);
    if(days === 0)
    {
        dayText = "ينتهي اليوم"
    }else if(days === 1)
    {
        dayText = `${late} يوم واحد`;
    }else if(days === 2){
        dayText = `${late} يومين`;
    }else if(days <= 10){
        dayText = `${late} ${days} أيام`;
    }else{
        dayText = `${late} ${days} يوما`;
    }
    return `<span class='${dayClass}'>  ${dayText}</span>`;
    */
    function getRemainingDaysSpanAttribute()
    {
        $rem = $this->remainingDays;
        $dayText = 0;
        $late = $rem < 0 ? " متأخر ب" : 'متبقي';
        $dayClass = $rem <= 0 ? 'text-danger' : '';
        $rem = abs($rem);
        if($rem === 0)
        {
            $dayText = "ينتهي اليوم";
        }else if($rem === 1)
        {
            $dayText = "${late} يوم واحد";
        }else if($rem === 2){
            $dayText = "${late} يومين";
        }else if($rem <= 10){
            $dayText = "$late $rem أيام";
        }else{
            $dayText = "$late $rem يوما";
        }
        return "<span class='$dayClass'>$dayText</span>";
    }


}
