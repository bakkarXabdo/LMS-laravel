<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Helpers\AppHelper;
use App\Imports\BooksImport;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\BookLanguage;
use App\Models\Category;
use App\Models\Rental;
use Cache;
use Carbon\Carbon;
use DB;
use Excel;
use Response;
use stdClass;
use Validator;

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

    public function import()
    {
        ini_set('max_execution_time', 99999);
        if(request()->files->count() === 0)
        {
            echo "لم يتم تحديد اي ملفات";
            exit;
        }
        $file = request()->file('data');
        $path = $file->getFileInfo()->getPathname();
        $content = file_get_contents($path);
        $hash = md5($content);
        $GLOBALS["fileHash"] = $hash;
        if(Cache::has('fileHash-'.$hash)) {
            (new BooksImport())->collection(collect(unserialize(Cache::get('fileHash-'.$hash), ["allowedClasses" => true])));
        }else {
            Excel::import(new BooksImport(), $path);
        }
    }
    public function export()
    {
        ini_set('max_execution_time', 600);
        $name = "out";
        $file = storage_path('app\public') . DIRECTORY_SEPARATOR . $name .'.xlsx';
        $oldLastUpdated = Carbon::parse(Cache::get('books-bookcopies-last-update'))->unix();
        $lastUpdatedAt = Book::query()->select(Db::raw("unix_timestamp(max(UpdatedAt)) as t"))->union(BookCopy::query()->select(Db::raw("unix_timestamp(max(UpdatedAt))")))->get()->max('t');
        $useOld = (int)$lastUpdatedAt === (int)$oldLastUpdated;
        if(!$useOld || !file_exists($file))
        {
            Excel::store(new BooksExport, "$name.xlsx", "public", \Maatwebsite\Excel\Excel::XLSX);
            Cache::put('books-bookcopies-last-update', $lastUpdatedAt);
        }
        $this->DownloadFile($file);
    }
    function DownloadFile($file) { // $file = include path
        if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='. basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }
    public function importing()
    {
        return view('books.importing');
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
        $book = Book::find($bookId)->withCount(['copies as NumberInStock', 'rentals as RentalsCount'])->first();
        if (!$book) {
            echo "";
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
        if (isset($book->{Book::KEY})) {
            $copiesCount = $book->copies->count();
            if ($book->rentals->count() > 0) {
                return Response::json((object) [
                    "success" => false,
                    "message" => "Book has active Rentals, <a href='"
                        . route('rentals.forbook', $bookId)
                        . "'>View</a>"
                ], 200);
            } else {
                try {
                    if (DB::transaction(function () use ($book) {
                        return $book->delete();
                    })) {
                        return Response::json((object)["success" => true, "message" => "<span dir='rtl' class='text-right'>" . AppHelper::ArabicFormat("تم حذف الكتاب (؟) و (؟) نُسخة بنجاح", [$bookId, $copiesCount]) . "</span>"], 200);
                    }
                }catch (\Throwable $e) {
                }
                return Response::json((object)["success" => false, "message" => "خطأ غير معروف لا يمكن حذف الكتاب"], 200);
            }
        } else {
            return Response::json((object) ["success" => false, "message" => AppHelper::ArabicFormat("الكتاب (؟) غير موجود", $bookId)], 200);
        }
    }

    public function table()
    {
        $request = json_decode(json_encode(request()->all()));
        $data = Book::query()->select([
            'books.*',
            Db::raw("@RentalsCount := (select count(*) from `". Rental::TABLE . "` where `". Book::TABLE ."`.`". Book::KEY ."` = `". Rental::TABLE ."`.`". Book::FOREIGN_KEY ."`) as `RentalsCount`"),
            Db::raw("@NumberInStock := (select count(*) from `". BookCopy::TABLE ."` where `". Book::TABLE ."`.`". Book::KEY ."` = `". BookCopy::TABLE ."`.`". Book::FOREIGN_KEY ."`) as `NumberInStock`"),
            Db::raw("@NumberInStock - @RentalsCount as `NumberAvailable`")
        ]);

        $rcol = collect(request()->all()['columns']);
        $rcol = $rcol->map(function ($col) use ($rcol) {
            $col['Id'] = $rcol->search($col);
            return $col;
        });
        if (!empty($request->search->value) && !ctype_space($request->search->value))
        {
            if(str_starts_with(strtolower($request->search->value), 'title:'))
            {
                $data->where("Title", 'Like', "%".substr($request->search->value, 6)."%");
            }else {
                $data->where(Book::KEY, 'LIKE', $request->search->value."%");
            }
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
            $book->EncodedKey = $book->EncodedKey;
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
