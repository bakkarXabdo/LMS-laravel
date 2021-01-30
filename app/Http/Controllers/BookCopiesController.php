<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Inventory;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use stdClass;

class BookCopiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $book = Book::find(request('bookId'));
        $inventory = Inventory::find(\request('inventoryId'));
        if(!$book && !$inventory)
        {
            abort(404);
        }
        return view('bookcopies.index', [
            "renting" => request('renting'),
            "customerId" => request('customerId'),
            "book" => $book,
            "inventory" => $inventory
        ]);
    }

    public function show($copyId)
    {
        $copy= BookCopy::find($copyId);
        if(!$copy)
        {
            abort(404, "book copy $copyId not found");
        }
        $copy->Rented = $copy->rental ? true : false;
        return view('bookcopies.show',[
            "copy"=>$copy
        ])->with($copy->attributesToArray());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(BookCopy $bookCopy)
    {
        //
    }


    public function update(Request $request, BookCopy $bookCopy)
    {
        //
    }


    public function destroy($copyId)
    {
        $copy = BookCopy::find($copyId);
        if(!$copy || !$copy->getKey())
        {
            abort(404, "copy not found");
        }
        $book = $copy->book;
        if(Db::transaction(function() use ($copy) {
            $copy->delete();
        }))
        {
            return redirect(route('bookcopies.show', $book->getKey()));
        }else{
            abort(500, "Internal Server Error");
        }
    }

    public function choose()
    {
        $book = Book::find(request('bookId'));
        if(!$book)
        {
            abort(404, 'book not found');
        }
        return view('bookcopies.index',[
            "book" => null,
            "inventory" => null,
            "renting" => true,
           "book" => $book,
           "customerId" => \request('customerId') ?: 'false'
        ]);
    }
    public function forInventory(Inventory $inventory)
    {
        //
    }
    public function table()
    {
        $request = json_decode(json_encode(request()->all()));
        $copies = null;
        if(isset($request->bookId) && $request->bookId)
        {
            $book = Book::find($request->bookId);
            if(!$book)
            {
                return abort(404);
            }
            $copies = $book->copies;
        }else if(isset($request->inventoryId) && $request->inventoryId){
            $inventory = Inventory::find($request->inventoryId);
            if(!$inventory)
            {
                return abort(404);
            }
            $copies = $inventory->copies;
        }else{
            abort(404, "Unknown request");
        }
        $count = $copies->count();
        $copies = $copies->sortBy('Rented', SORT_REGULAR, $request->order[0]->dir == 'desc');
        if($request->length > 0)
        {
            $copies = $copies->skip($request->start);
            $copies = $copies->take($request->length);
        }
        $copies->map(function(BookCopy $copy){
            $copy->Rented = 0;
            if($copy->rental)
            {
                // don't remove
                $copy->Rented = true;
                $customer = $copy->rental->customer;
                $copy->RentalId = $copy->rental->getKey();
                $copy->Customer = new stdClass;
                $copy->Customer->CardId = $customer->CardId;
                $copy->Customer->Id = $customer->Id;
                $copy->Customer->Name = $customer->Name;
            }
            $inventory = $copy->inventory;
            $copy->Shelf = $inventory->Shelf;
            $copy->Row = $inventory->Row;
            $copy->Column = $inventory->Column;
        });
        $resp = new stdClass;
        $resp->draw = $request->draw;
        $resp->recordsTotal = $copies->count();
        $resp->recordsFiltered = $count;
        $resp->data = $copies->values();
        return Response::json($resp);
    }
}
