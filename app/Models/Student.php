<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @mixin Builder
 */
class Student extends Model
{
    use HasFactory;


    /**-- DB RELATIONS --*/

    protected $table = "customers";
    protected $primaryKey = "Id";
    protected $guarded = ['Id'];

    const UPDATED_AT = null;
    const CREATED_AT = "CreatedAt";

    function rentals(){
        return $this->hasMany(Rental::class, 'StudentId', 'Id');
    }

    function user()
    {
        return $this->belongsTo(User::class, "UserId", "Id");
    }
}
