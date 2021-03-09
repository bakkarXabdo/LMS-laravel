<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Student;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use stdClass;

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

        Validator::extend('unique_student', function ($attribute, $value, $parameters, $validator) {


            if(Student::find($value))
            {
                $validator->setCustomMessages([
                    Student::KEY.'.unique_student' => "رقم الطالب $value موجود مسبقا"
                ]);
                return false;
            }
            return true;
        });
    }

    public function index()
    {
        return view('student.index');
    }

    public function create()
    {
        return view('student.create');
    }
    public function rules()
    {
        return [
            Student::KEY => 'required|unique_student',
            'Name' => 'required',
            'BirthDate' => 'required',
            'Speciality' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'Name.required' => "الرجاء إدخال إسم الطالب",
            'BirthDate.required' => 'الرجاء إدخال تاريخ الميلاد',
            'Speciality.required' => 'الرجاء إدخال التخصص',
        ];
    }
    public function store()
    {
        $validated = request()->validate($this->rules(), $this->messages());

        $pwd = strtolower(Str::random(4));
        $student = Db::transaction(function() use ($pwd, $validated) {
            $user = User::create([
                "username" => $validated[Student::KEY],
                "password" => Hash::make($pwd)
            ]);
            $validated[User::FOREIGN_KEY] = $user->getKey();
            return Student::create($validated);
        });
        if($student && $student->getKey())
        {
            Cache::put("student-password", $pwd);
            return redirect(route('students.show', $student->getKey()));
        }
        AppHelper::dieWithMessage("خطأ غير معروف, لا يمكن إدخال معلومات الطالب");
    }

    public function changePassword($customerId)
    {
        $customer = Student::find($customerId);
        if(!$customer)
        {
            AppHelper::dieWithMessage(AppHelper::ArabicFormat("الطالب {؟} غير موجود", $customerId));
        }
        $pwd = strtolower(Str::random(4));
        if($customer->user->update(["password" => Hash::make($pwd)]))
        {
            Cache::put("student-password", $pwd);
            return redirect(route('students.show', $customer->getKey()));
        }
        AppHelper::dieWithMessage("خطأ غير معروف, لا يمكن تحديث معلومات الطالب");
    }
    public function show($Id)
    {
        $student = Student::where(Student::KEY, $Id)->withCount(["rentals as RentalCount"])->first();
        if(!$student)
        {
            abort(404, 'student not found');
        }
        return view('student.show', [
            "student" => $student
        ])->with($student->attributesToArray());
    }
    public function choose()
    {
        return view('student.index',[
            "renting" => true,
            'copyId' => \request('copyId')
        ]);
    }
    public function edit($customerId)
    {
        $customer = Student::find($customerId);
        if(!$customer || !$customer->getKey())
        {
            AppHelper::dieWithMessage(AppHelper::ArabicFormat("الطالب {؟} غير موجود", \request($customerId)));
        }
        return view('student.edit')->with($customer->attributesToArray());
    }

    public function update()
    {
        $customer = Student::find(\request(Student::KEY));
        if(!$customer || !$customer->getKey())
        {
            AppHelper::dieWithMessage(AppHelper::ArabicFormat("الطالب {؟} غير موجود", \request(Student::KEY)));

        }

        $validated = \request()->validate([
            Student::KEY => 'required',
            'Name' => 'required',
            'BirthDate' => 'required'
        ]);

        if($customer->update($validated))
        {
            return redirect(route('students.show', $customer->getKey()));
        }

        AppHelper::dieWithMessage("خطأ غير معروف, لا يمكن تحديث معلومات الطالب");
    }

    public function typeahead()
    {
        $query = \request('query');
        $matches = Student::where(Student::KEY, 'LIKE', $query."%")
            ->select(Student::KEY)
            ->limit(4)->get()->map(function($result){
                return (string)$result->getKey();
            });
        return Response::json($matches);
    }

    public function destroy($customerId)
    {
        $customer = Student::find($customerId);
        if (isset($customer) && $customer->getKey()) {
            $rentalsCount = $customer->rentals->count();
            if($rentalsCount > 0) {
                return Response::json((object) [
                    "success" => false,
                    "message" => AppHelper::ArabicFormat("هذا الطالب يملك {؟} إعارة, <a style='color:blue;text-decoration:underline' href='", $rentalsCount)
                        . route('rentals.forcustomer', $customerId)
                        . "'>إظهار</a>"
                ], 200);
            }

            if (DB::transaction(function () use ($customer) {
                return $customer->delete();
            })) {
                return Response::json((object) ["success" => true, "message" => AppHelper::ArabicFormat("تم حذف الطالب {؟}", $customerId)], 200);
            }

            return Response::json((object) ["success" => false, "message" => "خطأ غير معروف, لا يمكن حذف الطالب"], 200);
        }

        return Response::json((object) ["success" => false, "message" => AppHelper::ArabicFormat("الطالب {؟} غير موجود", $customerId)], 200);
    }

    public function table()
    {
        // the request
        $request = json_decode(json_encode(request()->all()));
        $rcol = collect(request('columns'));
        $rcol = $rcol->map(function($col) use ($rcol) {
            $col['Id'] = $rcol->search($col);
            return $col;
        });

        // database
        $data = Student::query();
        $data->withCount(['rentals as RentalsCount']);

        // ordering
        foreach ($request->order as $order)
        {
            $data->orderBy($rcol->where('Id', '=', $order->column)->first()['name'], $order->dir);
        }

        // column search
        foreach ($request->columns as $index => $column)
        {
            if($column->searchable && $column->search->value)
            {
                $data->where($rcol->where('Id', '=', $index)->first()['name'], 'LIKE' ,'%'.$column->search->value.'%');
            }
        }

        // are we renting?
        if(isset($request->renting) && $request->renting)
        {
            // Do something special
        }

        // pagination
        $count = $data->count();
        if($request->length > 0)
        {
            $data->skip($request->start);
            $data->take($request->length);
        }

        // Response
        $resp = new stdClass;
        $resp->draw = $request->draw;
        $resp->recordsTotal = $data->count();
        $resp->recordsFiltered = $count;
        $resp->data = $data->get()->values();
        return Response::json($resp);
    }
}
