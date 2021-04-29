<?php

namespace App\Providers;

use App\Charts\BooksByCategoryChart;
use App\Charts\BooksByLanguageChart;
use App\Charts\MonthlyRentalsCountChart;
use App\Jobs;
use Carbon\Carbon;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use ConsoleTVs\Charts\Registrar as Charts;
use Exception;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //check if timezone is correct, it should be set on php.ini
        if(strtolower(date_default_timezone_get()) !== "africa/algiers")
        {
            date_default_timezone_set("Africa/Algiers");
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {

        Jobs::run();

        $charts->register([
            MonthlyRentalsCountChart::class,
            BooksByCategoryChart::class,
            BooksByLanguageChart::class,
        ]);
        if(app()->isLocal())
        {
            try {
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                die(" لا يمكن الإتصال بقاعدة البيانات" . "<br>" . $e ->getMessage() );
            }
        }
        AbstractPaginator::useBootstrapThree();
        Carbon::macro('getArabicMonths', function(){
            return [
                "جانفي",
                "فيفري",
                "مارس",
                "أفريل",
                "ماي",
                "جوان",
                "جويلية",
                "أوت",
                "سبتمير",
                "أكتوبر",
                "نوفمبر",
                "ديسمبر"
            ];
        });
        Carbon::macro('arabicDate', function(){
            return $this->day ." ". $this->getArabicMonths()[$this->month-1] ." ". $this->year;
        });
        Carbon::macro('arabicDateWithTime', function(){
            return $this->format('H:i | ') . $this->arabicDate();
        });
    }
}
