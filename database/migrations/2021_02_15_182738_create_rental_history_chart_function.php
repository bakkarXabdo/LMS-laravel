<?php

use App\Models\Rental;
use App\Models\RentalHistory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRentalHistoryChartFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public const NAME = "GET_RENTAL_HISTORY_CHART";
    public function up()
    {
        DB::unprepared("create procedure ". self::NAME ."()
BEGIN
        declare i int;
        declare diff timestamp;
        drop temporary table if exists result;
        CREATE TEMPORARY TABLE result(`month` int, `count` int);
        SET i = -12;
        While i != 0 do
            set diff = timestampadd(MONTH, i, NOW());
            insert into result values(-i-1, (select count(*) from `". Rental::TABLE ."` where `". Rental::CREATED_AT ."` between diff and timestampadd(MONTH, 1, diff)) + (select count(*) from `". RentalHistory::TABLE ."` where `". RentalHistory::CREATED_AT ."` between diff and timestampadd(MONTH, 1, diff)));
            SET i=i+1;
        End while;
        select * from result order by `month` desc;
        drop temporary table if exists result;
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
        DB::unprepared("drop procedure IF EXISTS ". self::NAME .";");
    }
}
