<?php

namespace App\Models\Traits;

use App\Models\Rental;

trait HasRentals
{
    function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
