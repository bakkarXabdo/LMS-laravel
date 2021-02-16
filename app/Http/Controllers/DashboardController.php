<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Student;
use App\Models\Rental;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('pages.dashboard',[
                'bookCount' => Book::count(),
                'BookCopiesCount' => BookCopy::count(),
                'CustomersCount' => Student::count(),
                'ActiveRentalsCount' => Rental::count(),
                'ExpiredRentalsCount' => Rental::query()->select(["rentals.*", Db::raw('timestampdiff(DAY ,now(),rentals.Expires) as `RemainingDays`')])->get()->where("RemainingDays", '<', 0)->count(),
                'MaxRentedCustomer' => Student::query()->withCount(['rentals as RentalsCount'])->orderByDesc('RentalsCount')->first()->RentalsCount
            ]);
    }
}
