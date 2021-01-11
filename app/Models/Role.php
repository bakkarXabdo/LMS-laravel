<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @mixin Builder
 */
class Role extends Model
{
    use HasFactory;


    /**-- DB RELATIONS --*/

    protected $table = "roles";

    function users(){
        return $this->belongsToMany(User::class);
    }
}
