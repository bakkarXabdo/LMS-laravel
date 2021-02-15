<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @mixin Builder
 */
class Inventory extends Model
{
    use HasFactory;


    /**-- DB RELATIONS --*/

    protected $table = "inventory";
    protected $primaryKey = "Id";
    protected $guarded = [];
    const UPDATED_AT = null;
    const CREATED_AT = null;

    function copies(){
        return $this->hasMany(BookCopy::class, 'InventoryId', 'Id');
    }

    function getPathAttribute()
    {
        return route('inventory.show', $this->getKey());
    }

    function getNotationAttribute()
    {
        return "$this->Shelf/$this->Column/$this->Row";
    }
}
