<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalHistory extends Model
{
    use HasFactory;

    protected $table = "rentals_history";

    protected $guarded = [];
    protected $primaryKey = "Id";

    const CREATED_AT = 'RentalReturnedAt';
    const UPDATED_AT = null;
}
