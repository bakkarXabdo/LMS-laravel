<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::TABLE, function (Blueprint $table) {
            $table->id(User::KEY);
            $table->string('Name');
            $table->boolean('IsAdmin')->default(0);
            $table->string('username');
            $table->string('password');
            $table->rememberToken();

            if(User::CREATED_AT) {
                $table->timestamp(User::CREATED_AT)->default(DB::raw("CURRENT_TIMESTAMP()"));
            }
            if(User::UPDATED_AT) {
                $table->timestamp(User::UPDATED_AT)->default(DB::raw("CURRENT_TIMESTAMP()"));
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
        Schema::dropIfExists(User::TABLE);
    }
}
