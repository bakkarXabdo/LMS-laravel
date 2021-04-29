<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Helpers\CacheList;
use App\Models\Book;
use App\Models\BookLanguage;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Request;

class PagesController extends Controller
{
    public function index()
    {
        if(Auth::user() && Auth::user()->IsAdmin)
        {
            return redirect(route('dashboard'));
        }
        $view = view('pages.index');
        $cache = 'pages.index.results.'.hash('md5', Request::getRequestUri());
        if(Cache::has($cache))
        {
            info("retrieving results from cache for request: ".Request::getRequestUri());
            return $view->with(unserialize(Cache::get($cache)));
        }
        info("retrieving results from database for request: ".Request::getRequestUri());
        $categories = Category::all();
        $languages = BookLanguage::all();
        $data = array(
            'results' => null,
            'categories' => $categories,
            'languages' => $languages,
            'splits' => collect()
        );
        $normalSearch = Book::query();
        // // column for book availability
        // $normalSearch->select(['books.*',
        //         DB::raw('@copiesCount := (select count(*) from bookcopies where bookcopies.BookId = books.InventoryNumber) as copiesCount'),
        //         DB::raw('@rentedCopiesCount := (select count(*) from bookcopies where bookcopies.BookId = books.InventoryNumber) as rentedCopiesCount'),
        //         DB::raw('@copiesCount - @rentedCopiesCount > 0 as available')]);
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
        CacheList::add('pages.index.results.cached', $cache, serialize($data));
        return $view->with($data);
    }
    public static function clearCachedResponses()
    {
        CacheList::forgetList('pages.index.results.cached');
    }
    public function about()
    {
        return view('pages.about');
    }
}
