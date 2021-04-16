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
use App\Rules\UniqueBook;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
        $name = "Books";
        $file = storage_path('app\public') . DIRECTORY_SEPARATOR . $name .'.xlsx';
        $oldLastUpdated = Carbon::parse(Cache::get('books-last-update'))->unix();
        $bcolumn = Book::UPDATED_AT ?? Book::CREATED_AT;
        $lastUpdatedAt = Book::query()->select(Db::raw("unix_timestamp(max($bcolumn)) as t"))->get()->max('t');
        $useOld = (int)$lastUpdatedAt === (int)$oldLastUpdated;
        if(!$useOld || !file_exists($file))
        {
            Excel::store(new BooksExport, "$name.xlsx", "public", \Maatwebsite\Excel\Excel::XLSX);
            Cache::put('books-last-update', $lastUpdatedAt);
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

    public function update(Request $request)
    {
        $book = Book::findOrFail($request->get('current_key'));
        $newdata = $this->validateRequest();
        DB::transaction(function () use($book, $newdata) {
            $updated = $book->update($newdata);
            if(strtoupper(request('current_key')) !== strtoupper(request(Book::KEY)))
            {
                foreach($book->copies as $copy)
                {
                    $updated = $updated && $copy->update([
                        BookCopy::KEY => $book->getKey() .'/'.$copy->copyNumber
                    ]);
                }
            }
            if(!$updated)
            {
                throw new Exception('book not updated');
            }
            return $updated;
        });
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
                    "message" => "الكتاب يملك نُسخة معارة, <a style='color: yellow; text-decoration:underline' href='"
                        . route('rentals.forbook', $bookId)
                        . "'>إضهار</a>"
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
        $id = request()->get('InventoryNumber');
        $categoryValidator = new InventoryNumberHasValidCategory($id);
        $languageValidator = new InventoryNumberHasValidLanguage($id);
        $rules = [
            'Title' => 'required|max:400|min:3',
            'Author' => 'max:255',
            'InventoryNumber' => ['required', new UniqueBook(request('current_key')), new HasValidInventoryNumber, $categoryValidator, $languageValidator],
            'Isbn' => 'max:50',
            'Source' => 'max:255',
            'Price' => 'max:255',
            'ReleaseYear' => 'max:4',
        ];
        $validated = Validator::make(request()->all(), $rules, [
            'Title.required' => 'عنوان الكتاب مطلوب',
            'Title.max' => 'العنوان يجب أن لا يتجاوز 255 حرف',
            'Title.min' => 'العنوان يجب أن يكون أكبر من ثلاثة أحرف',

            'Author.max' => 'المؤلف يجب أن لا يتجاوز 255 حرف',

            'InventoryNumber.required' => 'الشفره إجبارية',
            'InventoryNumber.unique' => 'الشفره موجودة مسبقا',

            'ReleaseYear.max' => 'سنة الإصدار يجب أن تكون 4 أرقام',
            'Price.max' => 'السعر يجب أن لا يتجاوز 255 حرف',
        ])->validate();
        $validated[Category::FOREIGN_KEY] = $categoryValidator->getCategory()->getKey();
        $validated[BookLanguage::FOREIGN_KEY] = $languageValidator->getLanguage()->getKey();
        return $validated;
    }
}
