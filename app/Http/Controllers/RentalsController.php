<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Student;
use App\Models\Rental;
use App\Models\RentalHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use stdClass;

class RentalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rentals.index',[
            "book" => null,
            "student" => null
        ]);
    }
    public function forBook($bookId)
    {
        $book = Book::find($bookId);
        if(!$book)
        {
            abort(404, 'book not found');
        }
        return view('rentals.index',[
            "book" => $book,
            "student" => null
        ]);
    }
    public function forStudent($studentId)
    {
        $student = Student::find($studentId);
        if(!$student || !$student->getKey())
        {
            abort(404, 'student not found');
        }
        return view('rentals.index',[
            "book" => null,
            "student" => $student
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $copy = BookCopy::find(\request(BookCopy::FOREIGN_KEY));
        $student = Student::find(\request(Student::FOREIGN_KEY));
        $confirming = request('confirming') || ($copy && $student);
        return view('rentals.create',compact('copy', 'student', 'confirming'));
    }

    public function store(Request $request)
    {
        if(request("confirming"))
        {
            return $this->create();
        }
        $student = Student::find(request(Student::FOREIGN_KEY));
        $copy = BookCopy::find(request(BookCopy::FOREIGN_KEY));
        if(!$student)
        {
            return "الطالب غير موجود";
        }
        if(!$copy)
        {
            return "النسخة غير موجودة";
        }
        if($copy->rental)
        {
            $show = "<a href='".route('rentals.show', $copy->rental->getKey())."'>" ."إضهار" ."</a>";
            return "$show هذه النسخة معاره مسبقا, ";
        }
        $rental = DB::transaction(function() use ($copy, $student) {
            $student->increment('TotalRentals');
            $copy->book->increment('TotalRentals');
            $copy->book->increment('Popularity');
            return Rental::create([
                Student::FOREIGN_KEY => $student->getKey(),
                BookCopy::FOREIGN_KEY => $copy->getKey(),
                Book::FOREIGN_KEY => $copy->book->getKey(),
                "ExpiresAt" => Carbon::now()->addDays(request()->get('duration'))->toDateTimeString()
            ]);
        });
        if($rental && $rental->getKey())
        {
            return redirect(route('rentals.show', $rental->getKey()));
        }else{
            abort(500, 'cant create rental Internal server error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\Response
     */
    public function show(Rental $rental)
    {
        return view('rentals.show',[
            "rental" => $rental
        ]);
    }

    public function returnRental(Rental $rental)
    {
        $rentalHistory = Db::transaction(function() use ($rental) {
            $r = null;
            try {
                $r = RentalHistory::create([
                    "StudentId" => $rental->student->getKey(),
                    "StudentName" => $rental->student->Name,
                    "BookCopyId" => $rental->copy->getKey(),
                    "BookTitle" => $rental->book->Title,
                    "RentalCreatedAt" => $rental->CreatedAt,
                    "RentalExpiresAt" => $rental->ExpiresAt,
                ]);
            }catch (Exception $e)
            {
                throw new Exception("لا يمكن إنشاء أرشيف للإعارة: " . $e->getMessage());
            }
            if($rental->delete()){
                return $r;
            }else{
                throw new Exception("لا يمكن حذف الإعارة");
            }
        });
        if($rentalHistory && $rentalHistory->getKey()){
            return redirect(route('history.show', $rentalHistory->getKey()));
        }

        return abort(500, "Internal Server Error");
    }
    public function ajaxReturnRental($rentalId)
    {
        $rental = Rental::find($rentalId);
        if(!$rental || !$rental->getKey())
        {
            abort(404, "Rental $rentalId not found");
        }
        $rentalHistory = Db::transaction(function() use ($rental) {
            $r = null;
            try {
                $r = RentalHistory::create([
                    "StudentId" => $rental->student->CardId,
                    "StudentName" => $rental->student->Name,
                    "BookId" => $rental->book->getKey(),
                    "BookTitle" => $rental->book->Title,
                    "RentalCreatedAt" => $rental->CreatedAt,
                    "RentalExpiresAt" => $rental->Expires,
                ]);
            }catch (Exception $e)
            {
                throw new Exception("لا يمكن إنشاء أرشيف للإعارة: " . $e->getMessage());
            }
            if($rental->delete()){
                return $r;
            }else{
                throw new Exception("لا يمكن حذف الإعارة");
            }
        });

        if($rentalHistory && $rentalHistory->getKey()){
            return Response::json((object) ["success" => true, "message" => "تم حذف الإعارة"], 200);
        }

        return Response::json((object) ["success" => false, "message" => "حدث خطأ غير معروف"], 200);
    }
    public function table()
    {
        $request = json_decode(json_encode(request()->all()));
        $rcol = collect(request('columns'));
        $rcol = $rcol->map(function($col) use ($rcol) {
            $col['Id'] = $rcol->search($col);
            return $col;
        });
        $rentalsData = Rental::query();
        $rentalsData = Book::joinWithSelf($rentalsData);
        $rentalsData = Student::joinWithSelf($rentalsData);
        $rentalsData = BookCopy::joinWithSelf($rentalsData);
        $rentalsData->select([
            Rental::TABLE . '.*',
            Book::TABLE . '.Title as BookTitle',
            Student::TABLE . '.Name as StudentName',
            Student::TABLE . '.' . Student::KEY . " as StudentId",
            Db::raw('timestampdiff(DAY , CURRENT_TIMESTAMP, ExpiresAt) as `RemainingDays`')
        ]);
        foreach ($request->order as $order)
        {
            $rentalsData->orderBy($rcol->where('Id', '=', $order->column)->first()['name'], $order->dir);
        }
        foreach ($request->columns as $index => $column)
        {
            if($column->searchable && $column->search->value)
            {
                $rentalsData->where($rcol->where('Id', '=', $index)->first()['name'], 'LIKE' ,'%'.$column->search->value.'%');
            }
        }
        if(isset($request->bookId))
        {
            if(!Book::find($request->bookId))
            {
                return abort(404, 'الكتاب غير موجود');
            }
            $rentalsData->where(Rental::TABLE . '.' . Book::FOREIGN_KEY,  $request->bookId);
        }
        if(isset($request->studentId))
        {
            if(!Student::find($request->studentId))
            {
                return abort(404, 'الطالب غير موجود');
            }
            $rentalsData->where(Rental::TABLE . '.' . Student::FOREIGN_KEY , $request->studentId);
        }
        $count = $rentalsData->count();
        if($request->length > 0)
        {
            $rentalsData->skip($request->start);
            $rentalsData->take($request->length);
        }
        $rentalsData = $rentalsData->get();
        $resp = new stdClass;
        $resp->draw = $request->draw;
        $resp->recordsTotal = $rentalsData->count();
        $resp->recordsFiltered = $count;
        $resp->data = $rentalsData->values();
        return Response::json($resp);
    }
}
