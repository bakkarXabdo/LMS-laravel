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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('language_id');
            $table->float('popularity');
            $table->integer('class_code');
            $table->string('title', 400);
            $table->string('authors');
            $table->year('release_year');

            $table->string('publisher');
            $table->string('isbn');
            $table->integer('price');
            $table->string('source');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('language_id')->references('id')->on('book_languages');

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
