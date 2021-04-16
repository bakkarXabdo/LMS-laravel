<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Helpers\CacheList;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Student;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            CacheList::store('student-speciality', request()->get('Speciality'));
            Cache::put("student-password", $pwd, now()->addMinutes(5));
            return redirect(route('students.show', $student->getKey()));
        }
        AppHelper::dieWithMessage("خطأ غير معروف, لا يمكن إدخال معلومات الطالب");
    }
    public function specialityTypeAhead()
    {
        return response()->json(CacheList::getList('student-speciality'));
    }
    public function changePassword(Student $student)
    {
        $pwd = strtolower(Str::random(4));
        if($student->user->update(["password" => Hash::make($pwd)]))
        {
            Cache::put("student-password", $pwd);
            return redirect(route('students.show', $student->getKey()));
        }
        AppHelper::dieWithMessage("خطأ غير معروف, لا يمكن تحديث معلومات الطالب");
    }
    public function show(Student $student)
    {
        return view('student.show', compact('student'));
    }
    public function choose()
    {
        return view('student.index',[
            "renting" => true,
            'copyId' => \request('copyId')
        ]);
    }
    public function edit($studentId)
    {
        $student = Student::find($studentId);
        if(!$student || !$student->getKey())
        {
            AppHelper::dieWithMessage(AppHelper::ArabicFormat("الطالب {؟} غير موجود", $studentId));
        }
        return view('student.edit', compact('student'));
    }

    public function update(Request $request)
    {
        $student = Student::findOrFail($request->get('current_key'));
        $validated = request()->validate([
            Student::KEY => 'required',
            'Name' => 'required',
            'BirthDate' => 'required'
        ]);

        if($student->update($validated))
        {
            return redirect(route('students.show', $student->getKey()));
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

    public function destroy($studentId)
    {
        $student = Student::find($studentId);
        if (isset($student) && $student->getKey()) {
            $rentalsCount = $student->rentals->count();
            if($rentalsCount > 0) {
                return Response::json((object) [
                    "success" => false,
                    "message" => AppHelper::ArabicFormat("هذا الطالب يملك {؟} إعارة, <a style='color:blue;text-decoration:underline' href='", $rentalsCount)
                        . route('rentals.forstudent', $studentId)
                        . "'>إظهار</a>"
                ], 200);
            }

            if (DB::transaction(function () use ($student) {
                return $student->delete();
            })) {
                return Response::json((object) ["success" => true, "message" => AppHelper::ArabicFormat("تم حذف الطالب {؟}", $studentId)], 200);
            }

            return Response::json((object) ["success" => false, "message" => "خطأ غير معروف, لا يمكن حذف الطالب"], 200);
        }

        return Response::json((object) ["success" => false, "message" => AppHelper::ArabicFormat("الطالب {؟} غير موجود", $studentId)], 200);
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
