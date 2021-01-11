<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @mixin Builder
 */
class Customer extends Model
{
    use HasFactory;


    /**-- DB RELATIONS --*/

    protected $table = "customers";

    function rentals(){
        return $this->hasMany(Rental::class);
    }
}
