<?php

namespace App\Models;

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

    function customer(){
        return $this->belongsTo(Customer::class);
    }

    function book(){
        return $this->belongsTo(Book::class);
    }

    function bookCopy(){
        return $this->belongsTo(BookCopy::class);
    }
}
