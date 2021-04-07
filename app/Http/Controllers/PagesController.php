<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Book;
use App\Models\BookLanguage;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
        if($searchTerm) {
            $authorsSearch->Where('Author', 'LIKE', "%$searchTerm%");
            $normalSearch->where(function ($query) use ($searchTerm) {
                $query->where('Title', 'LIKE', "%$searchTerm%");
            });
            $advnacedSearch->where(function ($query) use ($searchTerm) {
                $query->whereRaw("LOWER((REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(Title, '[,\-.()|:]', ''), 'ه', 'ة'), 'é', 'e'), 'ç', 'c'), 'ï', 'i'), '  ', ' '))) " .
                    "like CONCAT('%', LOWER((REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(REGEXP_REPLACE(?, '[,\-.()|:]', ''), 'ه', 'ة'), 'é', 'e'), 'ç', 'c'), 'ï', 'i'), '  ', ' '))), '%')", [$searchTerm]);
            });

            $wordsSearch->where(function ($q) use ($searchTerm) {
                $ignoreWords = collect([
                    "une",
                    "un",
                    "a",
                    "les",
                    "la",
                    "des",
                    "à",
                    'و',
                    'في',
                    'من',
                ]);
                foreach (collect(mb_split(' ', $searchTerm))->sort(fn($w1, $w2) => strlen($w1) < strlen($w2))
                         as $key => $word) {
                    $word = preg_replace('/[?.,\\\:()\-+]/', "", $word);
                    if (empty($word) || is_numeric($word) || strlen($word) < 3 || $ignoreWords->contains(strtolower($word))) {
                        continue;
                    }
                    if (strpos($word, 'ال') === 0) {
                        $word = str_replace('ال', '', $word);
                    }
                    $q->orWhere('Title', 'LIKE', "%$word%");
                }
            });
            $splits = [$normalSearch->count(), $advnacedSearch->count(), $wordsSearch->count(), $authorsSearch->count()];
            $splits = array_filter($splits, fn($v) => $v);
            $data['splits'] = collect($splits)->flatten();
            if (empty($splits))
            {
                $books = Book::all();
                $books->sort(function(Book $book1, Book $book2) use ($searchTerm) {
                    similar_text($book1->Title, $searchTerm, $bs1);
                    similar_text($book2->Title, $searchTerm, $bs2);
                    return $bs1 - $bs2;
                });
                $data['results'] = AppHelper::paginateCollection($books, 50);
            }else {
//            dd($s = $splits);
                $authorsSearch->orderByDesc('Popularity');
                $advnacedSearch->orderByDesc('Popularity');
                $wordsSearch->orderByDesc('Popularity');
                $normalSearch->union($advnacedSearch);
                $normalSearch->union($wordsSearch);
                $normalSearch->union($authorsSearch);
                $data['results'] = $normalSearch->paginate(50);
            }
        }else{
            $data['results'] = $normalSearch->paginate(50);
        }
        $response = view('pages.index')->with($data)->render();
        if(!Cache::has($cache))
        {
            Cache::put($cache, $response, now()->addDay());
            $cached = Cache::get('pages.index.view.cached', []);
            $cached[] = $cache;
            Cache::put('pages.index.view.cached', $cached);
        }
        return $response;
    }
    public static function clearCachedResponses()
    {
        $cached = Cache::get('pages.index.view.cached');
        if (is_array($cached)) {
            Cache::deleteMultiple($cached);
            Cache::forget('pages.index.view.cached');
        }
    }
    public function about()
    {
        return view('pages.about');
    }
}
