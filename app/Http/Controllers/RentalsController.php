<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Customer;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use stdClass;

class RentalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rentals.index',[
            "book" => null,
            "customer" => null
        ]);
    }
    public function forBook($bookId)
    {
        $book = Book::find($bookId);
        if(!$book)
        {
            abort(404, 'book not found');
        }
        return view('rentals.index',[
            "book" => $book,
            "customer" => null
        ]);
    }
    public function forCustomer(Customer $customer)
    {
        if(!$customer || !$customer->getKey())
        {
            abort(404, 'customer not found');
        }
        return view('rentals.index',[
            "book" => null,
            "customer" => $customer
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BookCopy $copy, Customer $customer)
    {
        return view('rentals.create',[
            "copy" => $copy,
            "customer" => $customer
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customerId' => 'required',
            'copyId' => 'required',
            'duration' => 'required|integer'
        ]);
        $customer = Customer::find(request('customerId'));
        $copy = BookCopy::find(\request('copyId'));
        if(!$customer)
        {
            return "Customer not found";
        }
        if(!$copy)
        {
            return "Copy not found";
        }
        if($copy->rental)
        {
            return "Copy is already Rented (<a href='".route('rentals.show', $copy->rental->getKey())."'>View</a>)";
        }
        $rental = Rental::create([
            "CustomerId" => $customer->getKey(),
            "BookCopyId" => $copy->getKey(),
            "BookId" => $copy->book->getKey(),
            "Expires" => Carbon::now()->addDays($validated['duration'])->toDateTimeString()
        ]);
        if($rental->save())
        {
            return redirect(route('rentals.show'));
        }else{
            abort(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function show(Rental $rental)
    {
        return view('rentals.show',[
            "rental" => $rental
        ]);
    }

    public function returnRental(Rental $rental)
    {
        $rental->delete();
        $r = Rental::where('Id', $rental->Id);
        $r->delete();
        return ":(";
    }

    public function table()
    {
        $request = json_decode(json_encode(request()->all()));
        $rcol = collect(request('columns'));
        $rcol = $rcol->map(function($col) use ($rcol) {
            $col['Id'] = $rcol->search($col);
            return $col;
        });
        $data = Rental::query();
        $data->join((new BookCopy)->getTable(), (new BookCopy)->getTable().'.'.(new BookCopy)->getKeyName(), '=', (new Rental)->getTable().'.BookCopyId')
            ->join((new Customer)->getTable(), (new Rental)->getTable().'.CustomerId', '=', (new Customer)->getTable().'.'.(new Customer)->getKeyName())
            ->join((new Book)->getTable(), (new Rental)->getTable().'.BookId', '=', (new Book)->getTable().'.'.(new Book)->getKeyName());
        $data->select([
            'rentals.*',
            'books.Title',
            'customers.Name',
            'customers.CardId',
            'bookcopies.BookId as `bookcopy.Id`',
            Db::raw('IF(Expires < NOW(), -1 * timestampdiff(DAY ,rentals.CreatedAt,now()), timestampdiff(DAY ,rentals.CreatedAt,now())) as `RemainingDays`')
        ]);
        foreach ($request->order as $order)
        {
            $data->orderBy($rcol->where('Id', '=', $order->column)->first()['name'], $order->dir);
        }
        foreach ($request->columns as $index => $column)
        {
            if($column->searchable && $column->search->value)
            {
                $data->where($rcol->where('Id', '=', $index)->first()['name'], 'LIKE' ,'%'.$column->search->value.'%');
            }
        }
        if(isset($request->bookId))
        {
            if(!Book::find($request->bookId))
            {
                return abort(404, 'book not found');
            }
            $data->where('rentals.BookId', '=', $request->bookId);
        }
        if(isset($request->customerId))
        {
            if(!Customer::find($request->customerId))
            {
                return abort(404, 'customer not found');
            }
            $data->where('rentals.CustomerId', '=', $request->customerId);
        }
        $count = $data->count();
        if($request->length > 0)
        {
            $data->skip($request->start);
            $data->take($request->length);
        }
        $data = $data->get();
        $data->map(function($rental){
            // don't remove
            $rental->customer = $rental->customer;
            $rental->copy = $rental->copy;
            $rental->book = $rental->book;
            return $rental;
        });
        $resp = new stdClass;
        $resp->draw = $request->draw;
        $resp->recordsTotal = $data->count();
        $resp->recordsFiltered = $count;
        $resp->data = $data->values();
        return Response::json($resp);
    }
}
