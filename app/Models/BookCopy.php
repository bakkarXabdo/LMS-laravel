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

    function book(){
        return $this->belongsTo(Book::class);
    }

    function rental(){
        return $this->hasOne(Rental::class);
    }

    function inventory(){
        return $this->belongsTo(Inventory::class);
    }
}
