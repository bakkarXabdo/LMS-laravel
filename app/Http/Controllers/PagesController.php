<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Helpers\CacheList;
use App\Models\Book;
use App\Models\BookLanguage;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class PagesController extends Controller
{
    public function index()
    {
        if(Auth::user() && Auth::user()->IsAdmin)
        {
            return (new DashboardController)->index();
        }
        $cache = 'pages.index.view.'.hash('md5', \Request::getRequestUri());
        if(Cache::has($cache))
        {
            return Cache::get($cache);
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

        $searchTerm = request('term');
        if(\request('category'))
        {
            $cid = Book::TABLE . "." . Category::FOREIGN_KEY;
            $data["filterCategory"] = $categories->find(\request('category'));
            $normalSearch->where($cid , \request('category'));
        }
        if(\request('language'))
        {
            $lid = Book::TABLE . "." . BookLanguage::FOREIGN_KEY;
            $data["filterLanguage"] = $languages->find(\request('language'));
            $normalSearch->where($lid, \request('language'));
        }
        $normalSearch->orderByDesc('Popularity');

        $advnacedSearch = $normalSearch->clone();
        $wordsSearch = $normalSearch->clone();
        $authorsSearch = $normalSearch->clone();
        $similarSearch = $normalSearch->clone();


        if($searchTerm) {
            $authorsSearch->where('Author', 'LIKE', "%$searchTerm%");
            $normalSearch->where('Title', 'LIKE', "%$searchTerm%");
            $advnacedSearch->whereRaw("LOWER((REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(Title, '[,\-.()|:]', ''), 'ه', 'ة'), 'é', 'e'), 'ç', 'c'), 'ï', 'i'), '  ', ' '))) " .
            "like CONCAT('%', LOWER((REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(?, '[,\-.()|:]', ''), 'ه', 'ة'), 'é', 'e'), 'ç', 'c'), 'ï', 'i'), '  ', ' '))), '%')", [$searchTerm]);

            $wordsSearch->where(function ($q) use ($searchTerm) {
                $ignoreWords = collect([
                    "une",
                    "les",
                    "des",
                    "d'un",
                    "d'une",
                    'dans',
                ]);
                foreach (collect(mb_split(' ', $searchTerm))->sort(fn($w1, $w2) => strlen($w1) < strlen($w2))
                         as $word) {
                    $word = preg_replace('/[?.,\\\:()\-+]/', '', $word);
                    if (empty($word) || is_numeric($word) || strlen($word) <= (is_arabic($word)?4:2) || $ignoreWords->contains(strtolower($word))) {
                        continue;
                    }
                    if (strpos($word, 'ال') === 0) {
                        $word = str_replace('ال', '', $word);
                    }
                    $q->orWhere('Title', 'LIKE', "%$word%");
                }
                // dd($dds);
            });
            // dd($wordsSearch);
            $splits = [$normalSearch->count(), $advnacedSearch->count(), $wordsSearch->count(), $authorsSearch->count()];

            $splits = array_filter($splits, fn($v) => $v);
            $data['splits'] = collect($splits)->flatten();
            if (empty($splits))
            {
                $books = $similarSearch->get();
                $books = $books->sort(function(Book $book1, Book $book2) use ($searchTerm) {
                    $m1 = similar_text($book1->Title, $searchTerm, $bs1);
                    $m2 = similar_text($book2->Title, $searchTerm, $bs2);
                    return ($m2-$m1)+($bs2 - $bs1);
                });
                $data['noresult'] = true;
                $data['results'] = AppHelper::paginateCollection($books, 50);
            }else {
//            dd($s = $splits);
                $normalSearch->union($advnacedSearch);
                $normalSearch->union($wordsSearch);
                $normalSearch->union($authorsSearch);
                $data['results'] = $normalSearch->paginate(50);
            }
        }else{
            $data['results'] = $normalSearch->paginate(50);
        }
        $response = view('pages.index')->with($data)->render();
        $response = preg_replace('/\s+/S', " ", $response);
        CacheList::add('pages.index.view.cached', $cache, $response);
        return $response;
    }
    public static function clearCachedResponses()
    {
        CacheList::forgetList('pages.index.view.cached');
    }
    public function about()
    {
        return view('pages.about');
    }
}
