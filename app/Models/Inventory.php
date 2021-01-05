<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;


    /**-- DB RELATIONS --*/

    function copies(){
        return $this->hasMany(BookCopy::class);
    }
}
