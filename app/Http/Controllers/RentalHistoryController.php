<?php

namespace App\Http\Controllers;

use App\Models\RentalHistory;
use Illuminate\Http\Request;

class RentalHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function show($historyId)
    {
        $history = RentalHistory::find($historyId);
        if(!$history)
        {
            return abort(404, "RentalHistory #$historyId Not Found");
        }
        return view('rentalHistory.show', [
            "history" => $history
        ]);
    }
}
