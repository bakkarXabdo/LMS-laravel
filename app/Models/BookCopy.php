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
    const CREATED_AT = "DateAdded";
    const UPDATED_AT = "DateUpdated";

    function book(){
        return $this->belongsTo(Book::class, 'BookId', 'Id', 'books');
    }

    function rental(){
        return $this->hasOne(Rental::class, 'BookCopyId', 'Id');
    }

    function inventory(){
        return $this->belongsTo(Inventory::class, 'InventoryId', 'Id', 'inventory');
    }
}
