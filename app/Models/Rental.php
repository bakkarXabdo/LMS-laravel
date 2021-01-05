<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;


    /**-- DB RELATIONS --*/

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