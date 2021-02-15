<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Book;
use App\Models\BookLanguage;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Builder\Property;


class PagesController extends Controller
{
    public function index()
    {
        if(Auth::user() && Auth::user()->IsAdmin)
        {
            return (new DashboardController)->index();
        }
        $categories = Category::all();
        $languages = BookLanguage::all();
        $data = array(
            'results' => null,
            'categories' => $categories,
            'languages' => $languages,
            'splits' => collect()
        );
        $normalSearch = Book::query();
        $advnacedSearch = Book::query();
        $wordsSearch = Book::query();
        $authorsSearch = Book::query();

        $searchTerm = request('term');
        if(\request('category'))
        {
            $data["filterCategory"] = $categories->where('Id', \request('category'))->first();
            $normalSearch->where('books.CategoryId', \request('category'));
            $advnacedSearch->where('books.CategoryId', \request('category'));
            $wordsSearch->where('books.CategoryId', \request('category'));
            $authorsSearch->where('books.CategoryId', \request('category'));
        }
        if(\request('language'))
        {
            $data["filterLanguage"] = $languages->where('Id', \request('language'))->first();
            $normalSearch->where('books.LanguageId', \request('language'));
            $advnacedSearch->where('books.LanguageId', \request('language'));
            $wordsSearch->where('books.LanguageId', \request('language'));
            $authorsSearch->where('books.LanguageId', \request('language'));
        }
        $normalSearch->orderByDesc('Popularity');
        if($searchTerm)
        {
            $authorsSearch->Where('Authors', 'LIKE', "%$searchTerm%");
            $normalSearch->where(function ($query) use ($searchTerm) {
                $query->where('Title', 'LIKE', "%$searchTerm%");
            });
            $advnacedSearch->where(function ($query) use ($searchTerm) {
                $query->whereRaw("LOWER((REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(Title, '[,\-.()|:]', ''), 'ه', 'ة'), 'é', 'e'), 'ç', 'c'), 'ï', 'i'), '  ', ' '))) " .
                    "like CONCAT('%', LOWER((REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(?, '[,\-.()|:]', ''), 'ه', 'ة'), 'é', 'e'), 'ç', 'c'), 'ï', 'i'), '  ', ' '))), '%')", [$searchTerm]);
            });

            $wordsSearch->where(function($q) use ($searchTerm) {
                $ignoreWords = collect([
                    "une",
                    "une",
                    "a",
                    "les",
                    "la",
                    "des",
                    "à",
                ]);
                foreach (collect(mb_split(' ', $searchTerm))->sort(function($w1, $w2){return strlen($w1) < strlen($w2);})
                         as $key => $word)
                {
                    $word = preg_replace("/[\\?\\.\\,\\:\\(\\)\\-\\+]/", "", $word);
                    if(empty($word) || is_numeric($word) || strlen($word) < 3 || $ignoreWords->contains(strtolower($word)))
                    {
                        continue;
                    }
                    $q->orWhere('Title', 'LIKE', "%$word%");
                }
            });
            $splits = [$normalSearch->count(), $advnacedSearch->count(), $wordsSearch->count(), $authorsSearch->count()];
            $s = $splits;
            $splits = array_filter($splits, static function($c){
                return $c;
            });
            $data['splits'] = collect($splits)->flatten();
//            dd($s = $splits);
            $authorsSearch->orderByDesc('Popularity');
            $advnacedSearch->orderByDesc('Popularity');
            $wordsSearch->orderByDesc('Popularity');
            $normalSearch->union($advnacedSearch);
            $normalSearch->union($wordsSearch);
            $normalSearch->union($authorsSearch);
        }
        $data['results'] = $normalSearch->paginate(50);
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