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
        Schema::create(BookCopy::TABLE, function (Blueprint $table){
            $table->string(BookCopy::KEY)->primary();
            $table->string('InventoryId')->nullable();
            $table->integer('TotalRentals')->default(0)->nullable();
            $table->string(Book::FOREIGN_KEY);

            $table->foreign(Book::FOREIGN_KEY)->references(Book::KEY)->on(Book::TABLE)->cascadeOnUpdate()->cascadeOnDelete();
            if(BookCopy::CREATED_AT) {
                $table->timestamp(BookCopy::CREATED_AT)->default(DB::raw("CURRENT_TIMESTAMP()"));
            }
            if(BookCopy::UPDATED_AT) {
                $table->timestamp(BookCopy::UPDATED_AT)->default(DB::raw("CURRENT_TIMESTAMP()"));
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
        Schema::dropIfExists(BookCopy::TABLE);
    }
}
