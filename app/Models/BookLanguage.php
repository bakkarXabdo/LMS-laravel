<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class BookLanguage extends Model
{
    use HasFactory;


    /**-- DB RELATIONS --*/

    protected $table = "languages";

    function books(){
        return $this->belongsToMany(Book::class, 'languages', 'Id', 'Id', 'Id', 'LanguageId', 'books');
    }
}
