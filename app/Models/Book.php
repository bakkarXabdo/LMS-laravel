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
    protected $table ="books";
    protected $primaryKey = "InventoryNumber";
    public const FOREIGN_KEY = "BookId";
    protected $keyType = "string";

    protected $guarded = [];

    public const CREATED_AT = "DateAdded";
    public const UPDATED_AT = null;

    /**-- Attributes --*/

    function getPathAttribute(){
        return route('books.show', $this->attributes['Id']);
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
        return $this->hasOne(BookLanguage::class, 'Id', 'LanguageId');
    }
    function category(){
        return $this->hasOne(Category::class, 'Id', 'CategoryId');
    }
    function copies(){
        return $this->hasMany(BookCopy::class, 'BookId', 'Id');
    }
    function rentals(){
        return $this->hasMany(Rental::class, 'BookId', 'Id');
    }
}
