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
use App\Rules\HasValidInventoryNumber;
use App\Rules\InventoryNumberHasValidCategory;
use App\Rules\InventoryNumberHasValidLanguage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use Maatwebsite\Excel\Facades\Excel;

class BooksController extends Controller
{
    public function index()
    {
        return view('books.index', [
            "choosing" => false,
            "studentId" => \request('studentId') ?: false
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
        PagesController::clearCachedResponses();
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
            (new BooksImport())->collection(collect(unserialize(Cache::get('fileHash-' . $hash), ["allowedClasses" => true])));
        }else {
            try {
                Excel::import(new BooksImport(), $path);
            }catch(NoTypeDetectedException $e)
            {
                report($e);
                echo "صيغة الملف غير مدعومة";
                exit;
            }
        }
    }
    public function export()
    {
        ini_set('max_execution_time', 600);
        $name = "BookCopies";
        $file = storage_path('app\public') . DIRECTORY_SEPARATOR . $name .'.xlsx';
        $oldLastUpdated = Carbon::parse(Cache::get('books-bookcopies-last-update'))->unix();
        $bcolumn = Book::UPDATED_AT ?? Book::CREATED_AT;
        $bccolumn = BookCopy::UPDATED_AT ?? BookCopy::CREATED_AT;
        $lastUpdatedAt = Book::query()->select(Db::raw("unix_timestamp(max($bcolumn)) as t"))->union(BookCopy::query()->select(Db::raw("unix_timestamp(max($bccolumn))")))->get()->max('t');
        $useOld = (int)$lastUpdatedAt === (int)$oldLastUpdated;
        if(!$useOld || !file_exists($file))
        {
            Excel::store(new BooksExport, "$name.xlsx", "public", \Maatwebsite\Excel\Excel::XLSX);
            Cache::put('books-bookcopies-last-update', $lastUpdatedAt);
        }
        AppHelper::DownloadFile($file);
    }

    public function importing()
    {
        return view('books.importing');
    }
    public function choose()
    {
        return view('books.index', [
                "choosing" => true,
                "studentId" => \request('studentId')
            ]);
    }
    public function store()
    {
        $request = $this->validateRequest();

        $book = Book::create($request);
        PagesController::clearCachedResponses();
        return redirect($book->path);
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update()
    {
        $request = $this->validateRequest();
        $book = Book::find(request()['Id']);
        if (!$book) {
            abort(404);
        }
        $book->update($request);
        PagesController::clearCachedResponses();
        return redirect($book->path);
    }

    public function destroy($bookId)
    {
        PagesController::clearCachedResponses();
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
        $data->map(function (Book $book) {
            // don't remove
            $book->Category = $book->category;
            $book->EncodedKey = $book->EncodedKey;
            return $book;
        });
        $resp = new \stdClass;
        $resp->draw = $request->draw;
        $resp->recordsTotal = $data->count();
        $resp->recordsFiltered = $count;
        $resp->data = $data->all();
        return Response::json($resp);
    }

    public function validateRequest()
    {
        $validated = Validator::make(request()->all(), [
            'Title' => 'required|max:255|min:3',
            'Author' => 'max:255',
            'InventoryNumber' => ['required', new HasValidInventoryNumber, new InventoryNumberHasValidCategory, new InventoryNumberHasValidLanguage],
            'Isbn' => 'max:50',
            'Source' => 'max:255',
            'Price' => 'max:255',
            'ReleaseYear' => 'max:4',
        ], [
            'Title.required' => 'عنوان الكتاب مطلوب',
            'Title.max' => 'العنوان يجب أن لا يتجاوز 255 حرف',
            'Title.min' => 'العنوان يجب أن يكون أكبر من ثلاثة أحرف',

            'Author.max' => 'المؤلف يجب أن لا يتجاوز 255 حرف',
            'InventoryNumber.required' => 'الشفره إجبارية',
            'ReleaseYear.max' => 'سنة الإصدار يجب أن تكون 4 أرقام',
            'Price.max' => 'السعر يجب أن لا يتجاوز 255 حرف',
        ])->validate();
        return $this->addRelatedModels($validated);
    }

    public function addRelatedModels($attributes)
    {
        preg_match('/^[A-Za-z]+/', $attributes['InventoryNumber'], $match);
        $id = $match[0];
        $code = substr($id, 0, -1);
        $attributes[Category::FOREIGN_KEY] = Category::where('code', $code)->first()->getKey();
        $code = substr($id, strlen($id)-1);
        $attributes[BookLanguage::FOREIGN_KEY] = BookLanguage::where('code', $code)->first()->getKey();
        return $attributes;
    }
}
