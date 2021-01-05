<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;


    /**-- DB RELATIONS --*/

    function language(){
        return $this->hasOne(BookLanguage::class);
    }
    function category(){
        return $this->hasOne(Category::class);
    }
    function copies(){
        return $this->hasMany(BookCopy::class);
    }
    function rentals(){
        return $this->hasMany(Rental::class);
    }
}
