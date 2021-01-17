<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLanguage;
use App\Models\Category;
use Illuminate\Http\Request;

class PagesController extends Controller
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
        $books = Book::all();
        $categories = Category::all();
        $langs = BookLanguage::all();
        $data = array(
            'books' => $books,
            'categories' => $categories,
            'langs' => $langs,
        );
        return view('pages.index')->with($data);
    }
    public function about()
    {
        return view('pages.about');
    }

    public function search()
    {

        $langs = BookLanguage::all();
        $search_text = $_GET['search_query'];
        $books = Book::orderBy('id', 'asc')->where('Title', 'LIKE', '%' . $search_text . '%')
            ->orWhere('Authors', 'LIKE', '%' . $search_text . '%')->get();
        $data = array(
            'books' => $books,
            'langs' => $langs
        );
        return view('pages.index')->with($data);
    }

    public function filter($id)
    {
        $langs = BookLanguage::all();
        $lang_id = BookLanguage::find($id);
        $books = Book::where('LanguageId', '=', $lang_id->Id)->get();
        $data = array(
            'books' => $books,
            'langs' => $langs
        );
        return view('pages.index')->with($data);
    }
}
