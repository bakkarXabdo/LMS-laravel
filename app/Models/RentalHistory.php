<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalHistory extends Model
{
    use HasFactory;

    protected $table = "rentalhistories";

    protected $guarded = [];

    const CREATED_AT = null;
    const UPDATED_AT = null;
}
