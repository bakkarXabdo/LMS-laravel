<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Integer;
use stdClass;
use Symfony\Component\VarDumper\Cloner\Data;

class BooksController extends Controller
{

    public function index()
    {
        return view('books.indexold', [
            "book" =>null
        ]);
    }
    public function create()
    {
        return view('book.create');
    }

    public function store()
    {
        $request = $this->validateRequest();
        $book = Book::create($request);
        $book->save();
        return redirect($book->path);
    }

    public function show(Integer $bookId)
    {
        $book = Book::find($bookId);
        if(!$book)
        {
            abort(404);
        }
        return view('book.show', ["book"=>$book]);
    }

    public function edit(Integer $bookId)
    {
        $book = Book::find($bookId);
        if(!$book)
        {
            abort(404);
        }
        return view('book.edit', ["book"=>$book]);
    }

    public function update()
    {
        $request = $this->validateRequest();
        $book = Book::find($request->id);
        $book->update($request);
        return redirect($book->path);
    }

    public function destroy(Integer $bookId)
    {
        $result = Book::destroy($bookId);
        if($result > 0)
        {
            return Response::json('success', 200);
        }else
        {
            return Response::json('error', 404);
        }
    }

    public function table()
    {
        $request = json_decode(json_encode(request()->all()));
        $data = Book::query();

        $rcol = collect(request()->all()['columns']);
        $rcol = $rcol->map(function($col) use ($rcol) {
            $col['Id'] = $rcol->search($col);
            return $col;
        });
        $title = json_decode(json_encode($rcol->where('name', '=', 'Title')->first()));
        $stock = json_decode(json_encode($rcol->where('name', '=', 'NumberInStock')->first()));
        $available = json_decode(json_encode($rcol->where('name', '=', 'NumberAvailable')->first()));
        $rented = json_decode(json_encode($rcol->where('name', '=', 'RentalsCount')->first()));
        $request->order = $request->order[0];
        $searched = false;
        if (!ctype_space($request->search->value) && !empty($request->search->value))
        {
            $data = $data->where('Title', 'LIKE', "%{$request->search->value}%");
            $searched = true;
        }
        if (isset($request->order)) {
            if ($request->order->column == $title->Id) {
                if ($request->order->dir == 'asc')
                    $data = $data->orderBy('Title');
                else
                    $data = $data->orderByDesc('Title');
            } else if ($request->order->column == $rented->Id) {
                $data = $data->join('rentals', 'books.Id', '=', 'BookId')
                    ->select(['books.*', DB::raw('count(books.Id) as RentalsCount')])
                    ->groupBy('rentals.BookId');
                if ($request->order->dir == 'asc')
                    $data->orderBy('RentalsCount');
                else
                    $data->orderByDesc('RentalsCount');
            } else if ($request->order->column == $stock->Id) {
                $data = $data->join('bookcopies', 'books.Id', '=', 'BookId')
                    ->select(['books.*', DB::raw('count(books.Id) as NumberInStock')])
                    ->groupBy('bookcopies.BookId');
                if ($request->order->dir == 'asc')
                    $data->orderBy('NumberInStock');
                else
                    $data->orderByDesc('NumberInStock');
            } else if ($request->order->column == $available->Id) {
                $avSql = "(select books_stocks_rentals.Id as AvId, (NumberInStock - RentalsCount) as NumberAvailable from (select books.*, NumberInStock, count(books.Id) as RentalsCount from books inner join (select books.Id as BookId, count(books.Id) as NumberInStock from books inner join bookcopies on books.Id = bookcopies.BookId group by bookcopies.BookId) as stocks on books.Id = stocks.BookId inner join rentals on books.Id = rentals.BookId group by rentals.BookId)  as books_stocks_rentals) as availables";
                $data->join(DB::raw($avSql), 'books.Id', '=', 'availables.AvId');
                if ($request->order->dir == 'asc')
                    $data->orderBy('NumberAvailable');
                else
                    $data->orderByDesc('NumberAvailable');
            }
        }
        $data = $data->orderByDesc('Popularity');
        //TODO: optimize only for search
        if($searched){
            $count = $data->count();
        }else{
            $count = Book::count();
        }

        $data = $data->skip($request->start);
        if ($request->length > 0)
        {
            $data = $data->take($request->length);
        }else{
            $data = $data->take(10);
        }
        $data = collect($data->get());
        $data->map(function($book){
            $book->Category = $book->category;
            $book->NumberInStock = $book->NumberInStock;
            $book->NumberAvailable = $book->NumberAvailable;
            $book->RentalsCount = $book->RentalsCount;
            return $book;
        });
        $resp = new stdClass;
        $resp->draw = $request->draw;
        $resp->recordsTotal = $data->count();
        $resp->recordsFiltered = $count;
        $resp->data = $data->all();
        return Response::json($resp);
    }

    public function validateRequest(){
        return Validator::make(request()->all(), [
            'title' => 'required|max:255',
            'authors' => 'required|max:255',

        ],[
            'title.required' => 'You must specify the title of the Book',
            'title.max' => 'The book title must be shorter than 255 characters',

            'authors.required' => 'You must specify the author(s) of the Book',
            'authors.max' => 'The book authors field must be shorter than 255 characters',
        ])->validate();
    }
}
