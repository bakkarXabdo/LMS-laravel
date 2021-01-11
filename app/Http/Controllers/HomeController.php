<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Customer;
use App\Models\Rental;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome',[
                'bookCount' => Book::count(),
                'BookCopiesCount' => BookCopy::count(),
                'CustomersCount' => Customer::count(),
                'ActiveRentalsCount' => Rental::where('returned', null)->count(),
                'ExpiredRentalsCount' => Rental::whereDate('expires', '>', 'now')->count(),
                'MaxRentedCustomer' => 0
            ]);
    }
}
