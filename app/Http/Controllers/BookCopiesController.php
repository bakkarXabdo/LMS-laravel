<?php

namespace App\Http\Controllers;

use App\Exports\BookCopiesExport;
use App\Helpers\AppHelper;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Student;
use App\Rules\SameBook;
use App\Rules\UniqueCopy;
use App\Rules\ValidBookInCopyId;
use App\Rules\ValidCopyId;
use Cache;
use Dotenv\Exception\ValidationException as ExceptionValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BookCopiesController extends Controller
{
    public function forBook(Book $book)
    {
        return view('bookcopies.forBook', [
            "renting" => request('renting'),
            "studentId" => request('studentId'),
            "book" => $book,
        ]);
    }
    public function index()
    {
        return view('bookcopies.index');
    }
    public function export()
    {
        ini_set('max_execution_time', 600);
        return (new BookCopiesExport)->download("copies.xlsx", \Maatwebsite\Excel\Excel::XLSX);
    }

    public function show(BookCopy $bookcopy)
    {
        return view('bookcopies.show',[
            "copy"=>$bookcopy
        ]);
    }

    public function create()
    {
        return view('bookcopies.create');
    }

    public function store()
    {
        $validated = $this->validateRequest();
        $copy = BookCopy::create($validated);
        if($copy)
        {
            return redirect(route('bookcopies.show', $copy->getKey()));
        }
        throw new HttpException(500, "لا يمكن إنشاء النسخة");
    }

    public function edit(BookCopy $bookcopy)
    {
        return view('bookcopies.edit', [
            "copy" => $bookcopy
        ]);
    }


    public function update(Request $request)
    {
        $bookcopy = BookCopy::findOrFail($request->get('current_key'));
        $validated = $this->validateRequest();
        if ($bookcopy->update($validated)) {
            return redirect($bookcopy->path);
        }
        throw new HttpException(500, "لا يمكن تعديل النسخة");
    }


    public function destroy(BookCopy $bookcopy)
    {
        try {
            if (!$bookcopy->exists) {
                throw new \Exception("النسخة غير موجودة");
            }
            $book = $bookcopy->book;
            if ($bookcopy->rental) {
                throw new \Exception("النسخة <a href='" . route('rentals.show', $bookcopy->rental->getKey()) . "'>معارة</a>");
            }
            if (!Db::transaction(fn() => $bookcopy->delete())) {
                throw new \Exception("خطأ غير معروف");
            }
        }catch(\Exception $e)
        {
            return request()->wantsJson() ?
                        response()->json(["success" => false, "message" => $e->getMessage()])
                        : abort(404, $e->getMessage());
        }
        return request()->wantsJson() ?
            response()->json(["success" => true, "message" => "تم حذف النسخة"])
            : redirect(route('bookcopies.forBook', $book->getKey()));
    }
    public function typeahead()
    {
        $query = request('query');
        $matches = BookCopy::where(BookCopy::KEY, 'LIKE', $query."%")
            ->select(BookCopy::KEY)
            ->whereDoesntHave('rental')
            ->limit(4)
            ->get()
            ->map(fn($copy) => $copy->getKey());
        return Response::json($matches);
    }
    public function choose()
    {
        $book = Book::find(request('bookId'));
        if(!$book)
        {
            abort(404, 'book not found');
        }
        return view('bookcopies.index',[
            "inventory" => null,
            "renting" => true,
           "book" => $book,
           "studentId" => \request('studentId') ?: 'false'
        ]);
    }
    public function table()
    {
        $request = json_decode(json_encode(request()->all()), FALSE);
        $rcol = collect(request('columns'));
        $rcol = $rcol->map(function($col) use ($rcol) {
            $col['Id'] = $rcol->search($col);
            return $col;
        });
        if(isset($request->bookId))
        {
            $book = Book::find($request->bookId);
            if(!$book)
            {
                throw new HttpException(404, "book not found");
            }
            $copies = $book->copies();
        }else{
            $copies = BookCopy::query();
        }

        foreach ($request->order as $order)
        {
            $copies->orderBy($rcol->where('Id', '=', $order->column)->first()['name'], $order->dir);
        }
        foreach ($request->columns as $index => $column)
        {
            if($column->searchable && $column->search->value)
            {
                $copies->where($rcol->where('Id', '=', $index)->first()['name'], 'LIKE' ,'%'.$column->search->value.'%');
            }
        }
        $copies->select([BookCopy::TABLE.'.*', DB::raw("(select count(*) from rentals where rentals.BookCopyId = bookcopies.Id) as Rented")]);
        $count = $copies->count();
        if($request->length > 0)
        {
            $copies->skip($request->start);
            $copies->take($request->length);
        }
        $copies = $copies->get();
        $copies->map(function(BookCopy $copy){
            $copy->Rented = false;
            $copy->Id = $copy->getKey();
            if($copy->rental)
            {
                // don't remove
                $copy->Rented = true;
                $student = $copy->rental->student;
                $copy->RentalId = $copy->rental->getKey();
                $copy->Student = new stdClass;
                $copy->Student->Id = $student->{ Student::KEY };
                $copy->Student->Name = $student->Name;
            }
        });
        $resp = new stdClass;
        $resp->draw = $request->draw;
        $resp->recordsTotal = $copies->count();
        $resp->recordsFiltered = $count;
        $resp->data = $copies->values();
        return Response::json($resp);
    }

    public function validateRequest()
    {
        $keyName = BookCopy::KEY;
        $bookValidator = new ValidBookInCopyId(request($keyName));
        $idrules = ['required', new UniqueCopy(request('current_key'))];
        if(strtoupper(request('current_key')) !== strtoupper(request(BookCopy::KEY))){
            $idrules[] = new SameBook(request('current_key'), request($keyName));
        }
        $idrules[] = new ValidCopyId;
        $idrules[] = $bookValidator;
        $atts = Validator::make(request()->all(),[
            $keyName => $idrules,
            'InventoryId' => 'max:255'
        ])->validate();
        $atts[Book::FOREIGN_KEY] = $bookValidator->getBook()->getKey();
        return $atts;
    }
}
