<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Books', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('CategoryId');
            $table->foreignId('LanguageId');
            $table->float('Popularity');
            $table->integer('ClassCode');
            $table->string('Title', 400);
            $table->string('Authors');
            $table->year('ReleaseYear');

            $table->string('Publisher');
            $table->string('Isbn');
            $table->integer('Price');
            $table->string('Source');
            $table->timestamps();

            $table->foreign('CategoryId')->references('Id')->on('Categories');
            $table->foreign('LanguageId')->references('Id')->on('BookLanguages');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
