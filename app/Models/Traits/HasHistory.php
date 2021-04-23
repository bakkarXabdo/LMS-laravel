<?php

namespace App\Models\Traits;

use App\Models\RentalHistory;

trait HasHistory
{
    function rentalHistories()
    {
        return $this->hasMany(RentalHistory::class);
    }
}
