<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */

class Book extends Model
{
    use HasFactory;


    /**-- Attributes --*/

    function getPathAttribute(){
        return route('book.view', $this->attributes['id']);
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
