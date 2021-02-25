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
            $cid = Book::TABLE . "." . Category::FOREIGN_KEY;
            $data["filterCategory"] = $categories->find(\request('category'));
            $normalSearch->where($cid , \request('category'));
            $advnacedSearch->where($cid, \request('category'));
            $wordsSearch->where($cid, \request('category'));
            $authorsSearch->where($cid, \request('category'));
        }
        if(\request('language'))
        {
            $lid = Book::TABLE . "." . BookLanguage::FOREIGN_KEY;
            $data["filterLanguage"] = $languages->find(\request('language'));
            $normalSearch->where($lid, \request('language'));
            $advnacedSearch->where($lid, \request('language'));
            $wordsSearch->where($lid, \request('language'));
            $authorsSearch->where($lid, \request('language'));
        }
        $normalSearch->orderByDesc('Popularity');
        if($searchTerm)
        {
            $authorsSearch->Where('Author', 'LIKE', "%$searchTerm%");
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
                    if(strpos($word, 'ال') === 0)
                    {
                        $word = str_replace('ال', '', $word);
                    }
                    $q->orWhere('Title', 'LIKE', "%$word%");
                }
            });
            $splits = [$normalSearch->count(), $advnacedSearch->count(), $wordsSearch->count(), $authorsSearch->count()];
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