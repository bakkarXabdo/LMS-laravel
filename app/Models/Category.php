<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @mixin Builder
 */
class Category extends Model
{
    use HasFactory;


    /**-- DB RELATIONS --*/

    protected $table = "categories";
    protected $primaryKey = "Id";

    function books(){
        return $this->belongsToMany(Book::class, 'books', 'Id');
    }
}
