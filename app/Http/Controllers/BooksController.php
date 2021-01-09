<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Integer;
use Yajra\DataTables\Facades\DataTables;

class BooksController extends Controller
{

    public function index()
    {
        return view('book.list');
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
        return $this->datatables
            ->eloquent(Book::limit(100))
            ->make(true);
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
