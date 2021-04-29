<?php

use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUpdateBookPopularitySchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public const NAME = "UPDATE_BOOK_POPULARITY";
    public function up()
    {
        DB::unprepared("CREATE EVENT ". self::NAME ." ON SCHEDULE
EVERY 1 MONTH STARTS NOW()
ENABLE
DO BEGIN
    SET @DIV = least(2, greatest(1.4, (select 1 + log(max(Popularity), avg(Popularity)) from `". Book::TABLE ."`)));
    UPDATE `". Book::TABLE ."` SET Popularity = Popularity / @DIV;
END;
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("drop event IF EXISTS ". self::NAME .";");
    }
}
