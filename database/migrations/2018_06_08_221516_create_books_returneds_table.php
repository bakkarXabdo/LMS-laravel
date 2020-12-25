<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksReturnedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_returneds', function (Blueprint $table) {
          $table->increments('returnId');
          $table->dateTime('retDate')->nullable(false);
          $table->unsignedInteger('bookId')->nullable(false);
          $table->unsignedInteger('memId')->nullable(false);
          $table->foreign('bookId')->references('bookId')->on('books');
          $table->foreign('memId')->references('memId')->on('members');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books_returneds');
    }
}
