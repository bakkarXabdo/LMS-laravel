<?php

declare(strict_types = 1);

namespace App\Charts;

use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonthlyRentalsCountChart extends BaseChart
{

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

        $monthIterator = now()->addMonths(-11);
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
            $m = $monthIterator->format('F');
            if(array_key_exists($m, $months))
            {
                $m = $months[$m];
            }
            $labels[] =  $m;
            $monthIterator->addMonth();
        }
        $chart->labels($labels);
        $chart->dataset("عدد الإعارات في الأشهر الماضية", $rentalHistoryDataSet);
        return $chart;
    }

}
