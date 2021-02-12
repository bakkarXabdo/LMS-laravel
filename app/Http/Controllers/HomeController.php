<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Customer;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $book = Book::find(97740);
        $copies = BookCopy::query()->select(['bookcopies.Id'])->join('rentals', 'rentals.BookCopyId', 'bookcopies.Id')->where('bookcopies.BookId', $book->getKey())->get();
        BookCopy::query()->whereNotIn('bookcopies.Id', $copies)->where('bookcopies.BookId', $book->getKey())->first();
        return view('pages.dashboard',[
                'bookCount' => Book::count(),
                'BookCopiesCount' => BookCopy::count(),
                'CustomersCount' => Customer::count(),
                'ActiveRentalsCount' => Rental::count(),
                'ExpiredRentalsCount' => Rental::query()->select(["rentals.*", Db::raw('timestampdiff(DAY ,now(),rentals.Expires) as `RemainingDays`')])->get()->where("RemainingDays", '<', 0)->count(),
                'MaxRentedCustomer' => Customer::query()->withCount(['rentals as RentalsCount'])->orderByDesc('RentalsCount')->first()->RentalsCount
            ]);
    }
}
