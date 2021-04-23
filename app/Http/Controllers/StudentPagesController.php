<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\RentalHistory;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentPagesController extends Controller
{
    public function showActiveRentals()
    {
        $rentals = Rental::where(Student::FOREIGN_KEY, Auth::user()->student->getKey())
                    ->with(['book', 'copy'])
                    ->get();
        return view('student.active_rentals')->with(compact('rentals'));
    }

    public function showRentalHistory()
    {
        $histories = RentalHistory::where(Student::FOREIGN_KEY, Auth::user()->student->getKey())
                    ->with(['book', 'copy'])
                    ->get();
        return view('student.rental_history')->with(compact('histories'));
    }
}
