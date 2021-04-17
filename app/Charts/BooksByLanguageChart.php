<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\BookLanguage;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;

class BooksByLanguageChart extends BaseChart
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
        $values1 = [];
        $values2 = [];
        foreach(BookLanguage::all() as $language)
        {
            $labels[] = $language->Name;
            $values1[] = $language->books()->count();
            $values2[] = $language->copies()->count();
        }
        $chart->labels($labels);
        $chart->dataset('عدد الكُتب حسب اللٌغة', $values1);
        $chart->dataset('عدد النُسخ حسب اللٌغة', $values2);
        return $chart;
    }
}
