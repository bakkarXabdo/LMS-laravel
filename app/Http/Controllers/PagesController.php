<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Models\Book;
use App\Models\BookLanguage;
use App\Models\Category;
use Chartisan\PHP\Chartisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class PagesController extends Controller
{
    public function index()
    {
        if(Auth::user() && Auth::user()->IsAdmin)
        {
            return (new HomeController)->index();
        }
//        DB::transaction(function(){
//           $books = Book::all();
//           $books = $books->shuffle();
//           foreach ($books as $book)
//           {
//               $r = rand(0, 100);
//               if($r < 2)
//               {
//                   $book->Popularity = rand(40, 80);
//               }else if($r < 5){
//                   $book->Popularity = rand(20, 40);
//               }else if($r < 10){
//                   $book->Popularity = rand(10, 20);
//               }else if($r < 20){
//                   $book->Popularity = rand(5, 10);
//               }else if($r < 40){
//                   $book->Popularity = rand(3, 5);
//               }else if($r < 60){
//                   $book->Popularity = rand(1, 3);
//               }
//               $book->save();
//           }
//        });
//        exit;
        $categories = Category::all();
        $languages = BookLanguage::all();
        $data = array(
            'results' => $results = Book::query(),
            'categories' => $categories,
            'languages' => $languages
        );
        $searchTerm = request('term');
        if(\request('category'))
        {
            $data["filterCategory"] = $categories->where('Id', \request('category'))->first();
            $data['results']->where('books.CategoryId', \request('category'));
        }
        if(\request('language'))
        {
            $data["filterLanguage"] = $languages->where('Id', \request('language'))->first();
            $data['results']->where('books.LanguageId', \request('language'));
        }

        if($searchTerm)
        {
            $clone = Book::query();
            // don't look at this
            \Closure::bind(function ($q){$this->query->wheres = $q->wheres;$this->query->bindings = $q->bindings;}, $clone, get_class($clone))(\Closure::bind(function(){return $this->query;}, $data['results'], get_class($data['results']))());
            $clone->where(function ($query) use ($searchTerm) {
                $query->where('Title', 'LIKE', "%$searchTerm%")
                    ->orWhere('Authors', 'LIKE', "%$searchTerm%");
            });
            $data['results']->where(function ($query) use ($searchTerm) {
                $query->whereRaw("LOWER((REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(Title, '[,\-.()|:]', ''), 'ه', 'ة'), 'é', 'e'), 'ç', 'c'), 'ï', 'i'), '  ', ' '))) " .
                    "like CONCAT('%', LOWER((REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE('$searchTerm', '[,\-.()|:]', ''), 'ه', 'ة'), 'é', 'e'), 'ç', 'c'), 'ï', 'i'), '  ', ' '))), '%')")
                    ->orWhere('Authors', 'LIKE', "%$searchTerm%");
            });
            $data['results']->union($clone);
        }
        $data['results']->orderBy('Popularity');
        $data['results'] = $data['results']->paginate(50);
        return view('pages.index')->with($data);
    }
    public function about()
    {
        return view('pages.about');
    }

    public function test()
    {
        return view('tests.test');
    }
}