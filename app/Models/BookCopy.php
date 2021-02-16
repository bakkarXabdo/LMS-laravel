<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class BookCopy extends Model
{
    use HasFactory;


    /**-- DB RELATIONS --*/

    protected $table = "bookcopies";
    protected $primaryKey = "Id";
    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $guarded = [];
    protected $keyType = "string";

    function book(){
        return $this->belongsTo(Book::class, 'BookId', (new Book)->getKeyName(), 'books');
    }

    function rental(){
        return $this->hasOne(Rental::class, 'BookCopyId', $this->getKeyName());
    }
}
