<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Rental;
use App\Models\RentalHistory;
use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartsController extends BaseChart
{
    public ?string $name = 'charts';
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $chart = Chartisan::build();
        $labels = [];
        $rentalHistoryDataSet = array_map(static function($item) {
            return $item->count;
        },Db::select("call GET_RENTAL_HISTORY_CHART();"));

        $now = Carbon::now();
        $temp = $now;
        $temp->addMonths(-12);
        for($i = 0; $i < 12; $i++)
        {
            $labels[] = $temp->format('F (m-Y)');
            $temp->addMonth();
        }
        $chart->labels($labels);
        $chart->dataset("N. Rentals Created Each Month", $rentalHistoryDataSet);
        return $chart;
    }

}