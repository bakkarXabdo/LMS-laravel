<?php

use App\Models\BookLanguage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lang = new BookLanguage();
        Schema::create($lang->getTable(), function (Blueprint $table) use ($lang) {
            $table->id($lang->getKeyName());
            $table->string('Name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((new BookLanguage)->getTable());
    }
}
