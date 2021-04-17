<?php

namespace App\Charts;

use App\Http\Middleware\IsAdmin;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart as Chart;
use Exception;
use Illuminate\Http\Request;

class BaseChart extends Chart
{
    public ?array $middlewares = [IsAdmin::class];

    public function handler(Request $request): Chartisan
    {
        throw new Exception('not implemented');
    }
}
