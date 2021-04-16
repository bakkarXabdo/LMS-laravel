<?php

namespace App\Providers;

use App\Charts\ChartsController;
use App\Models\BookCopy;
use App\Models\Student;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\View;

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
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die(" لا يمكن الإتصال بقاعدة البيانات" . "<br>" . $e ->getMessage() );
        }


        $charts->register([
            ChartsController::class
        ]);
        AbstractPaginator::useBootstrapThree();

        //check if timezone is correct, it should be set on php.ini
        if(strtolower(date_default_timezone_get()) !== "africa/algiers")
        {
            date_default_timezone_set("Africa/Algiers");
        }
    }
}
