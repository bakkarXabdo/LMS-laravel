<?php

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnStudentDeleteRemoveUserTrigger extends Migration
{
    private const NAME = "on_student_deleted_remove_user_trigger";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER ".self::NAME." AFTER DELETE on ". Student::TABLE ."
FOR EACH ROW
BEGIN
DELETE FROM ". User::TABLE ."
    WHERE ".User::KEY." = old.".User::FOREIGN_KEY.";
END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER " . self::NAME);
    }
}
