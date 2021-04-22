<?php

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Student::TABLE, function (Blueprint $table) {
            $table->string(Student::KEY)->primary();
            $table->foreignId('UserId');
            $table->string('Name');
            $table->string('Speciality');
            $table->dateTime('BirthDate', 6);
            $table->integer('TotalRentals')->default(0);

            $table->foreign('UserId')->references(User::KEY)->on(User::TABLE)->cascadeOnUpdate()->cascadeOnDelete();
            if(Student::CREATED_AT) {
                $table->timestamp(Student::CREATED_AT)->default(DB::raw("CURRENT_TIMESTAMP()"));
            }
            if(Student::UPDATED_AT) {
                $table->timestamp(Student::UPDATED_AT)->default(DB::raw("CURRENT_TIMESTAMP()"));
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Student::TABLE);
    }
}
