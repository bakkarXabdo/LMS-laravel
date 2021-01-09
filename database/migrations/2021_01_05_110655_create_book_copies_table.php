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
        Schema::create('BookCopies', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('BookId');
            $table->foreignId('InventoryId');
            $table->boolean('Rented');
            $table->timestamps();

            $table->foreign('BookId')->references('Id')->on('Books');
            $table->foreign('InventoryId')->references('Id')->on('Inventories');
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
