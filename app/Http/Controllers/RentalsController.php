<?php

namespace App\Http\Controllers;

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
            "customer" => null
        ]);
    }
    public function forCustomer($customerId)
    {
        $customer = Student::find($customerId);
        if(!$customer || !$customer->getKey())
        {
            abort(404, 'customer not found');
        }
        return view('rentals.index',[
            "book" => null,
            "customer" => $customer
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $c = BookCopy::find(\request(BookCopy::FOREIGN_KEY));
        $s = Student::find(\request(Student::FOREIGN_KEY));
        $co = $c && $s ? "true" : "false";
        return view('rentals.create',[
            "copy" => $c,
            "customer" => $s,
            "confirming" => \request('confirming') ? 'false' : $co
        ]);
    }

    public function store(Request $request)
    {
        if(request("confirming"))
        {
            return $this->create();
        }
        $validated = $request->validate([
            'studentId' => 'required',
            'copyId' => 'required',
            'duration' => 'required|integer'
        ]);
        $student = Student::find(request('customerId'));
        $copy = BookCopy::find(\request('copyId'));
        if(!$customer)
        {
            return "Customer not found";
        }
        if(!$copy)
        {
            return "Copy not found";
        }
        if($copy->rental)
        {
            return "Copy is already Rented (<a href='".route('rentals.show', $copy->rental->getKey())."'>View</a>)";
        }
        $rental = Rental::create([
            "CustomerId" => $student->getKey(),
            "BookCopyId" => $copy->getKey(),
            "BookId" => $copy->book->getKey(),
            "Expires" => Carbon::now()->addDays($validated['duration'])->toDateTimeString()
        ]);
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

    public function returnRental($rentalId)
    {
        $rental = Rental::find($rentalId);
        if(!$rental || !$rental->getKey())
        {
            return abort(404, "Rental $rentalId not found");
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
        $data = Rental::query();
        $data = Book::joinWithSelf($data);
        $data = Student::joinWithSelf($data);
        $data = BookCopy::joinWithSelf($data);
        $data->select([
            Rental::TABLE . '.*',
            Book::TABLE . '.Title as BookTitle',
            Student::TABLE . '.Name as StudentName',
            Student::TABLE . '.' . Student::KEY . " as StudentId",
            Db::raw('timestampdiff(DAY , CURRENT_TIMESTAMP, ExpiresAt) as `RemainingDays`')
        ]);
        foreach ($request->order as $order)
        {
            $data->orderBy($rcol->where('Id', '=', $order->column)->first()['name'], $order->dir);
        }
        foreach ($request->columns as $index => $column)
        {
            if($column->searchable && $column->search->value)
            {
                $data->where($rcol->where('Id', '=', $index)->first()['name'], 'LIKE' ,'%'.$column->search->value.'%');
            }
        }
        if(isset($request->bookId))
        {
            if(!Book::find($request->bookId))
            {
                return abort(404, 'الكتاب غير موجود');
            }
            $data->where(Rental::TABLE . '.' . Book::FOREIGN_KEY,  $request->bookId);
        }
        if(isset($request->studentId))
        {
            if(!Student::find($request->studentId))
            {
                return abort(404, 'الطالب غير موجود');
            }
            $data->where(Rental::TABLE . '.' . Student::FOREIGN_KEY , $request->studentId);
        }
        $count = $data->count();
        if($request->length > 0)
        {
            $data->skip($request->start);
            $data->take($request->length);
        }
        $data = $data->get();
        $resp = new stdClass;
        $resp->draw = $request->draw;
        $resp->recordsTotal = $data->count();
        $resp->recordsFiltered = $count;
        $resp->data = $data->values();
        return Response::json($resp);
    }
}
