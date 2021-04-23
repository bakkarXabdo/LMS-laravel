<?php

namespace App\Http\Controllers;

use App\Helpers\CacheList;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TypeAheadController extends Controller
{
    public function speciality()
    {
        return response()->json(CacheList::getList('student-speciality'));
    }
    public function studentId(Request $request)
    {
        $matches = Student::where(Student::KEY, 'LIKE', $request['query']."%")
            ->select(Student::KEY)
            ->limit(4)
            ->get()
            ->map(fn($student)=>(string) $student->getKey());
        return Response::json($matches);
    }
}
