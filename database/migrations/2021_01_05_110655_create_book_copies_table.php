<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookCopiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookcopies', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('BookId');
            $table->foreignId('InventoryId');
            $table->boolean('Rented');
            $table->timestamps();

            $table->foreign('BookId')->references('Id')->on('books');
            $table->foreign('InventoryId')->references('Id')->on('inventory');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_copies');
    }
}
