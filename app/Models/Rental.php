<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @mixin Builder
 */
class Rental extends Model
{
    use HasFactory;

    /**-- DB RELATIONS --*/

    protected $table = "rentals";
    protected $primaryKey = "Id";
    protected $guarded = ['Id'];

    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = null;

    function customer(){
        return $this->belongsTo(Customer::class, 'CustomerId', 'Id');
    }

    function book(){
        return $this->belongsTo(Book::class, 'BookId', 'Id');
    }

    function copy(){
        return $this->belongsTo(BookCopy::class, "BookCopyId", "Id");
    }
    function getReturnDateAttribute()
    {
        $diff =  Carbon::parse($this->attributes['Expires'])->diffInDays(Carbon::now());
        if(Carbon::parse($this->attributes['Expires'])->lessThan(Carbon::now())){
            $diff = -1 * $diff;
        }
        return intval($diff);
    }
}
