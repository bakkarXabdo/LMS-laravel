<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('CustomerId');
            $table->foreignId('BookId');
            $table->foreignId('BookCopyId');
            $table->timestamp('ExpiresAt', 6);
            $table->timestamp('ReturnedAt', 6);
            $table->timestamps();

            $table->foreign('CustomerId')->references('Id')->on('customers');
            $table->foreign('BookId')->references('Id')->on('books');
            $table->foreign('BookCopyId')->references('Id')->on('bookcopies');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rentals');
    }
}
