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

        $categories = Category::all();
        $langs = BookLanguage::all();
        $langs = BookLanguage::all();
        $search_text = $_GET['search_query'];
        $search_book = Book::orderBy('id', 'asc')->where('Title', 'LIKE', '%' . $search_text . '%')
            ->orWhere('Authors', 'LIKE', '%' . $search_text . '%')->get();
        $data = array(
            'search_book' => $search_book,
            'categories' => $categories,
            'langs' => $langs
        );
        return view('pages.search')->with($data);
    }

    public function filter($id)
    {
        
        $categories = Category::all();
        $langs = BookLanguage::all();
        $lang_id = BookLanguage::find($id);
        $filter_book = Book::where('LanguageId', '=', $lang_id->Id)->get();
        $data = array(
            'filter_book' => $filter_book,
            'categories' => $categories,
            'langs' => $langs
        );
        return view('pages.filter')->with($data);
    }

    public function filterCategory($id)
    {
        $langs = BookLanguage::all();
        $categories = Category::all();
        $category_id = Category::find($id);
        $filter_book_cat = Book::where('CategoryId', '=', $category_id->Id)->get();
        $data = array(
            'filter_book_cat' => $filter_book_cat,
            'categories' => $categories,
            'langs' => $langs
        );
        return view('pages.filter_category')->with($data);
    }
}
