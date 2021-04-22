<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Exports\HistoryExport;
use App\Helpers\AppHelper;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\RentalHistory;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RentalHistoryController extends Controller
{
    public function show($historyId)
    {
        $history = RentalHistory::find($historyId);
        if(!$history)
        {
            return abort(404, "RentalHistory #$historyId Not Found");
        }
        return view('rentalHistory.show', [
            "history" => $history
        ]);
    }

    public function index(Request $request)
    {
        $query = RentalHistory::orderBy(RentalHistory::CREATED_AT);
        if($request->has(Student::FOREIGN_KEY))
        {
            $query->where(Student::FOREIGN_KEY, $request->get(Student::FOREIGN_KEY));
        }
        if($request->has(BookCopy::FOREIGN_KEY))
        {
            $query->where(BookCopy::FOREIGN_KEY, $request->get(BookCopy::FOREIGN_KEY));
        }
        if($request->has(Book::FOREIGN_KEY))
        {
            $query->where(Book::FOREIGN_KEY, $request->get(Book::FOREIGN_KEY));
        }
        return view('rentalHistory.index', ["results" => $query->paginate(500)]);
    }

    public function export()
    {
        return view('rentalHistory.export', [
            'starting' => DB::table('rentals_history')->select(Db::raw("unix_timestamp(min(".RentalHistory::CREATED_AT.")) as v"))->first()->v ?? now()->subYear(),
            'ending' => DB::table('rentals_history')->select(Db::raw("unix_timestamp(max(".RentalHistory::CREATED_AT.")) as v"))->first()->v ?? now()->addYear(),
        ]);
    }

    public function exporting(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        if(Carbon::parse($start)->greaterThan(Carbon::parse($end)))
        {
            return "تاريخ النهاية يجب أن يكون أكبر من تاريخ النهاية";
        }
        ini_set('max_execution_time', 600);
        return (new HistoryExport($start, $end))->download("History.xls",  \Maatwebsite\Excel\Excel::XLSX);
    }
}
