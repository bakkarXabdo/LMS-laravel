<?php

use App\Models\RentalHistory;
use App\Models\Student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOnStudentUpdateRentalHistoryTrigger extends Migration
{
    private const NAME = "on_student_update_rental_history_trigger";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("create trigger ".self::NAME."
	after update
	on ".Student::TABLE."
	for each row
	BEGIN
UPDATE ".RentalHistory::TABLE." as r
    SET
        r.".Student::FOREIGN_KEY." = NEW.".Student::KEY.",
        r.StudentName = NEW.Name
    WHERE r.".Student::FOREIGN_KEY." = OLD.".Student::KEY.";
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
