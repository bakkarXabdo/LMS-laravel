<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Inventory;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use stdClass;

class BookCopiesController extends Controller
{

    public function index()
    {
        return abort(404);
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


    public function destroy(BookCopy $bookCopy)
    {
        //
    }

    public function forBook($bookId){
        $book = Book::find($bookId);
        if(!$book)
        {
            abort(404);
        }
        return view('bookcopies.forbook', [
            "book" => $book,
            "renting" => request('renting'),
            "customerId" => request('customerId')
        ]);
    }
    public function choose()
    {
        $book = Book::find(request('bookId'));
        if(!$book)
        {
            abort(404, 'book not found');
        }
        return view('bookcopies.forbook',[
            "renting" => true,
           "book" => $book,
           "customerId" => \request('customerId') ?: 'false'
        ]);
    }
    public function forInventory(Inventory $inventory)
    {
        //
    }
    public function forBookTable()
    {
        $request = json_decode(json_encode(request()->all()));
        $book = Book::find($request->bookId);
        $copies = $book->copies;
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

    public function forInventoryTable(Inventory $inventory)
    {
        //
    }
}
