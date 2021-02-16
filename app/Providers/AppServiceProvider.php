<?php

namespace App\Providers;

use App\Charts\ChartsController;
use App\Models\BookCopy;
use App\Observers\BookCopyObserver;
use Illuminate\Pagination\AbstractPaginator;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        $charts->register([
            ChartsController::class
        ]);
        AbstractPaginator::useBootstrapThree();

        //check if timezone is correct, it should be set on php.ini
        if(strtolower(date_default_timezone_get()) !== "africa/algiers")
        {
            date_default_timezone_set("Africa/Algiers");
        }
        BookCopy::observe(BookCopyObserver::class);
    }
}
