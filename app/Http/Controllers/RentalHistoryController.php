<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Exports\HistoryExport;
use App\Helpers\AppHelper;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\RentalHistory;
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

    public function index()
    {
        return view('rentalHistory.index', ["results" => RentalHistory::orderBy(RentalHistory::CREATED_AT)->paginate(500)]);
    }

    public function export()
    {
        return view('rentalHistory.export', [
            'starting' => RentalHistory::query()->select(Db::raw("unix_timestamp(max(".RentalHistory::CREATED_AT.")) as t"))->get()->min('t') ?? now()->unix()
        ]);
    }

    public function exporting(Request $request)
    {
        ini_set('max_execution_time', 600);
        $name = "History";
        $file = storage_path('app\public') . DIRECTORY_SEPARATOR . $name .'.xlsx';
        $oldLastUpdated = Carbon::parse(Cache::get('history-export-last-update'))->unix();
        $lastUpdatedAt = RentalHistory::query()->select(Db::raw("unix_timestamp(max(".RentalHistory::CREATED_AT.")) as t"))->get()->max('t');
        $useOld = (int)$lastUpdatedAt === (int)$oldLastUpdated;
        if(!$useOld || !file_exists($file))
        {
            Excel::store(new HistoryExport($request->get('start'), $request->get('end')), "$name.xlsx", "public", \Maatwebsite\Excel\Excel::XLSX);
            Cache::put('history-export-last-update', $lastUpdatedAt);
        }
        AppHelper::DownloadFile($file);
    }
}
