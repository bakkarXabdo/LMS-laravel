<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Category;
use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;

class BooksByCategoryChart extends BaseChart
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
        foreach(Category::all() as $category)
        {
            $labels[] = $category->Name;
            $values1[] = $category->books()->count();
            $values2[] = $category->copies()->count();
        }
        $chart->labels($labels);
        $chart->dataset('عدد الكُتب حسب الفئة', $values1);
        $chart->dataset('عدد النُسخ حسب الفئة', $values2);
        return $chart;
    }
}
