<?php

use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBookIdCheckerTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
CREATE TRIGGER ON_INSERT_BOOK_ID_CHECKER
BEFORE INSERT
ON `". (new Book)->getTable() ."`
FOR EACH ROW
BEGIN
    IF NOT(REGEXP_LIKE(NEW.". (new Book)->getKeyName() .", '^[A-Za-z]+\/[0-9]+$'))
    THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'BOOK ID must be LIKE XXX/00/00';
    END IF;
END;
CREATE TRIGGER ON_UPDATE_BOOK_ID_CHECKER
BEFORE UPDATE
ON `". (new Book)->getTable() ."`
FOR EACH ROW
BEGIN
    IF NOT(REGEXP_LIKE(NEW.". (new Book)->getKeyName() .", '^[A-Za-z]+\/[0-9]+$'))
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
        DB::unprepared("DROP TRIGGER IF EXISTS ON_INSERT_BOOK_ID_CHECKER;
        DROP TRIGGER IF EXISTS ON_UPDATE_BOOK_ID_CHECKER;");
    }
}
