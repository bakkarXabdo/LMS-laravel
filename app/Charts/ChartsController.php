<?php

declare(strict_types = 1);

namespace App\Charts;

use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use CreateRentalHistoryChartRoutine;
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
        $temp->addMonths(-11);
        $months = array(
            "January" => "جانفي",
            "February" => "فيفري",
            "March" => "مارس",
            "April" => "أفريل",
            "May" => "ماي",
            "June" => "جوان",
            "July" => "جويلية",
            "August" => "أوت",
            "September" => "سبتمبر",
            "October" => "أكتوبر",
            "November" => "نوفمبر",
            "December" => "ديسمبر"
        );
        for($i = 0; $i < 12; $i++)
        {
            $m = $temp->format('F');
            if(array_key_exists($m, $months))
            {
                $m = $months[$m];
            }
            $labels[] =  $m;
            $temp->addMonth();
        }
        $chart->labels($labels);
        $chart->dataset("عدد الإعارات في الأشهر الماضية", $rentalHistoryDataSet);
        return $chart;
    }

}