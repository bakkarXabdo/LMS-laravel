<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use stdClass;

class BookCopiesController extends Controller
{
    public function index(Book $book)
    {
        if(!$book->exists())
        {
            echo request('bookId') . "الكتاب غير موجود ";
            exit;
        }
        return view('bookcopies.index', [
            "renting" => request('renting'),
            "studentId" => request('studentId'),
            "book" => $book,
        ]);
    }

    public function show($copyId)
    {
        $copy= BookCopy::find($copyId);
        if(!$copy)
        {
            abort(404, "book copy $copyId not found");
        }
        $copy->Rented = $copy->rental;
        return view('bookcopies.show',[
            "copy"=>$copy
        ])->with($copy->attributesToArray());
    }

    public function create(Request $request)
    {
        return view('bookcopies.create');
    }

    public function store(Request $request)
    {
        $book = Book::find($request->get('BookId'));
        if(!$book || !Str::startsWith($request->get('Id'), $request->get('BookId')))
        {
           preg_match('/'.Book::getIncludedIdPattern().'/', $request->get('Id'), $mactches);
           $test = $mactches[0];
           $book = Book::find($request->get($mactches[0]));
        }
        if(!$book)
        {
            return back()->withErrors(new MessageBag(["Id" => "الكتاب $test غير موجود"]));
        }
        if(!preg_match('/'.BookCopy::getIdPattern().'/', $request->get('Id'), $macthes))
        {
            return back()->withErrors(new MessageBag(["Id" => "الشفرة غير صحيحه, يجب أن تكون من الشكل XXX/000/000"]));
        }
        if(BookCopy::find($request->get('Id')))
        {
            return back()->withErrors(new MessageBag(["Id" => "الشفرة موجوده مسبقا"]));
        }
        $copy = BookCopy::create([
            'Id' => $request->Id,
            "BookId" => $book->getKey(),
            "InventoryId" => $request->get('InventoryId')
        ]);
        if(!$copy)
        {
            abort(501, "Internal Server Error");
        }
        return redirect(route('bookcopies.show', $copy->getKey()));
    }

    public function edit(BookCopy $bookcopy)
    {
        abort(404, "Action not available");
        if(!$bookcopy)
        {
            return abort(404, "Copy Not Found");
        }
        return view('bookcopies.edit', [
            "copy" => $bookcopy
        ]);
    }


    public function update(Request $request, BookCopy $bookcopy)
    {
        abort(404, "Action not available");
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
            : redirect(route('bookcopies.index', $book->getKey()));
    }
    public function typeahead()
    {
        $query = \request('query');
        $matches = BookCopy::where(BookCopy::KEY, 'LIKE', $query."%")
            ->select(BookCopy::KEY)
            ->limit(4)->get()->map(function($result){
                return $result->getKey();
            });
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
        $request = json_decode(json_encode(request()->all()));
        $copies = null;
        if(isset($request->bookId))
        {
            $book = Book::find($request->bookId);
            if(!$book)
            {
                return abort(404, "Book not found");
            }
            $copies = $book->copies;
        }else{
            abort(404, "Book not found");
        }
        $count = $copies->count();
        $copies = $copies->sortBy('Rented', SORT_REGULAR, $request->order[0]->dir == 'desc');
        if($request->length > 0)
        {
            $copies = $copies->skip($request->start);
            $copies = $copies->take($request->length);
        }
        $copies->map(function(BookCopy $copy){
            $copy->Rented = false;
            $copy->EncodedKey = $copy->EncodedKey;
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
}
