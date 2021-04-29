<?php

use App\Models\Book;
use App\Models\RentalHistory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOnBookUpdateRentalHistoryTrigger extends Migration
{
    private const NAME = "on_book_update_rental_history_trigger";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("create trigger ".self::NAME."
	after update
	on ".Book::TABLE."
	for each row
	BEGIN
UPDATE ".RentalHistory::TABLE." as r
    SET
        r.".Book::FOREIGN_KEY." = NEW.".Book::KEY.",
        r.BookTitle = NEW.Title
    WHERE r.".Book::FOREIGN_KEY." = OLD.".Book::KEY.";
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
