<?php

use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBookIdCheckerOnInsertTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public const NAME = "BEFORE_INSERT_BOOK_ID_CHECKER";

    public function up()
    {
        DB::unprepared("
CREATE TRIGGER ". self::NAME ."
BEFORE INSERT
ON `". Book::TABLE ."`
FOR EACH ROW
BEGIN
    IF NOT(REGEXP_LIKE(NEW.". Book::KEY .", '^[A-Za-z]+\/[0-9]+$'))
    THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'BOOK ID must be LIKE XXX/00/00';
    END IF;
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
        DB::unprepared("DROP TRIGGER IF EXISTS ". self::NAME .";");
    }
}
