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
        $user = new User();
        $student = new Student();
        Schema::create($student->getTable(), function (Blueprint $table) use ($user, $student) {
            $table->id($student->getKeyName());
            $table->foreignId('UserId');
            $table->string('Name');
            $table->string('Speciality');
            $table->dateTime('BirthDate', 6);

            $table->foreign('UserId')->references($user->getKeyName())->on($user->getTable())->cascadeOnUpdate();
            if($student::CREATED_AT) {
                $table->timestamp($student::CREATED_AT);
            }
            if($student::UPDATED_AT) {
                $table->timestamp($student::UPDATED_AT);
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
        Schema::dropIfExists((new Student)->getTable());
    }
}
