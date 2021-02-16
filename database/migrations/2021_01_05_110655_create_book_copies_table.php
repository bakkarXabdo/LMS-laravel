<?php

use App\Models\Book;
use App\Models\BookCopy;
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
        $copy = new BookCopy;
        $book = new Book;
        Schema::create($copy->getTable(), function (Blueprint $table) use ($book, $copy) {
            $table->string($copy->getKeyName())->primary();
            $table->string($book::FOREIGN_KEY)->nullable(false);

            $table->foreign($book::FOREIGN_KEY)->references($book->getKeyName())->on($book->getTable())->cascadeOnUpdate()->cascadeOnDelete();
            if($copy::CREATED_AT) {
                $table->timestamp($copy::CREATED_AT);
            }
            if($copy::UPDATED_AT) {
                $table->timestamp($copy::UPDATED_AT);
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
        Schema::dropIfExists((new BookCopy)->getTable());
    }
}
