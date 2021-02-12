<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\BookLanguage;
use App\Models\Category;
use App\Models\Customer;
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
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index()
    {
        return view('books.index', [
            "choosing" => false,
            "customerId" => \request('customerId') ?: false
        ]);
    }
    public function create()
    {
        return view('books.create', [
            'categories' => Category::all(),
            'languages' => BookLanguage::all()
        ]);
    }

    public function choose()
    {
        return view('books.index', [
                "choosing" => true,
                "customerId" => \request('customerId')
            ]);
    }
    public function store()
    {
        $request = $this->validateRequest();
        $book = Book::create($request);
        $book->save();
        return redirect($book->path);
    }

    public function show($bookId)
    {
        $book = Book::where('Id', '=', $bookId)->withCount(['copies as NumberInStock', 'rentals as RentalsCount'])->first();
        if (!$book) {
            abort(404);
        }
        $book->NumberAvailable = $book->NumberInStock - $book->RentalsCount;
        return view('books.show', ["book" => $book])->with($book->attributesToArray());
    }

    public function edit($bookId)
    {
        $book = Book::find($bookId);
        if (!$book) {
            abort(404);
        }
        return view('books.edit', [
            "book" => $book,
            'categories' => Category::all(),
            'languages' => BookLanguage::all()
        ])->with($book->attributesToArray());
    }

    public function update()
    {
        $request = $this->validateRequest();
        $book = Book::find(request()['Id']);
        if (!$book) {
            abort(404);
        }
        $book->update($request);
        return redirect($book->path);
    }

    public function destroy($bookId)
    {
        $book = Book::find($bookId);
        if (isset($book->Id)) {
            if ($book->rentals->count() > 0) {
                return Response::json((object) [
                    "success" => false,
                    "message" => "Book has active Rentals, <a href='"
                        . route('rentals.forbook', $bookId)
                        . "'>View</a>"
                ], 200);
            } else {
                if (DB::transaction(function () use ($book) {
                    return $book->delete();
                })) {
                    return Response::json((object) ["success" => true, "message" => "Book #$bookId Was Removed"], 200);
                } else {
                    return Response::json((object) ["success" => false, "message" => "Unknown Error occurred"], 200);
                }
            }
        } else {
            return Response::json((object) ["success" => false, "message" => "Book #$bookId Was Not Found"], 200);
        }
    }

    public function table()
    {
        $request = json_decode(json_encode(request()->all()));
        $data = Book::query()->select([
            'books.*',
            Db::raw('@RentalsCount := (select count(*) from `rentals` where `books`.`Id` = `rentals`.`BookId`) as `RentalsCount`'),
            Db::raw('@NumberInStock := (select count(*) from `bookcopies` where `books`.`Id` = `bookcopies`.`BookId`) as `NumberInStock`'),
            Db::raw('@NumberInStock - @RentalsCount as `NumberAvailable`')
        ]);

        $rcol = collect(request()->all()['columns']);
        $rcol = $rcol->map(function ($col) use ($rcol) {
            $col['Id'] = $rcol->search($col);
            return $col;
        });
        if (!ctype_space($request->search->value) && !empty($request->search->value))
        {
//            if(str_starts_with(strtolower($request->search->value), 'id:'))
//            {
//                $data->where((new Book)->getKeyName(), '=', substr($request->search->value, 3));
//            }else {
//                $data->where('Title', 'LIKE', "%{$request->search->value}%");
//            }
            $data->where((new Book)->getKeyName(), '=', $request->search->value);
        }
        if(isset($request->choosing))
        {
            // you probably want to sort by Availability first
            $data->orderByDesc('NumberAvailable');
        }
        foreach ($request->order as $order) {
            $data->orderBy($rcol->where('Id', '=', $order->column)->first()['name'], $order->dir);
        }
        $data = $data->orderByDesc('Popularity');
        $count = $data->count();
        if ($request->length > 0) {
            $data = $data->skip($request->start);
            $data = $data->take($request->length);
        }
        $data = $data->get();
        $data->map(function ($book) {
            // don't remove
            $book->Category = $book->category;
            return $book;
        });
        $resp = new stdClass;
        $resp->draw = $request->draw;
        $resp->recordsTotal = $data->count();
        $resp->recordsFiltered = $count;
        $resp->data = $data->all();
        return Response::json($resp);
    }

    public function validateRequest()
    {
        return Validator::make(request()->all(), [
            'Title' => 'required|max:255',
            'Authors' => 'required|max:255',
            'ClassCode' => 'required',
            'LanguageId' => 'required',
            'CategoryId' => 'required'
        ], [
            'Title.required' => 'You must specify the title of the Book',
            'Title.max' => 'The book title must be shorter than 255 characters',

            'Authors.required' => 'You must specify the author(s) of the Book',
            'Authors.max' => 'The book authors field must be shorter than 255 characters',
        ])->validate();
    }
}
