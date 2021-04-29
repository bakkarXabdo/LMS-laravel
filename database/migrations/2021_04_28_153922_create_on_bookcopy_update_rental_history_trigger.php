<?php

use App\Models\BookCopy;
use App\Models\RentalHistory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOnBookcopyUpdateRentalHistoryTrigger extends Migration
{
    private const NAME = "on_bookcopy_update_rental_history_trigger";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("create trigger ".self::NAME."
	after update
	on ".BookCopy::TABLE."
	for each row
	BEGIN
UPDATE ".RentalHistory::TABLE." as r
    SET
        r.".BookCopy::FOREIGN_KEY." = NEW.".BookCopy::KEY."
    WHERE r.".BookCopy::FOREIGN_KEY." = OLD.".BookCopy::KEY.";
END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("drop trigger if exists ".self::NAME.";");
    }
}
