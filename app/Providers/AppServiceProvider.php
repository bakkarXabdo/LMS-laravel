<?php

namespace App\Providers;

use App\Charts\BooksByCategoryChart;
use App\Charts\BooksByLanguageChart;
use App\Charts\MonthlyRentalsCountChart;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use ConsoleTVs\Charts\Registrar as Charts;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        if(app()->isLocal())
        {
            try {
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                die(" لا يمكن الإتصال بقاعدة البيانات" . "<br>" . $e ->getMessage() );
            }
        }
        $charts->register([
            MonthlyRentalsCountChart::class,
            BooksByCategoryChart::class,
            BooksByLanguageChart::class,
        ]);
        AbstractPaginator::useBootstrapThree();

        //check if timezone is correct, it should be set on php.ini
        if(strtolower(date_default_timezone_get()) !== "africa/algiers")
        {
            date_default_timezone_set("Africa/Algiers");
        }
    }
}
