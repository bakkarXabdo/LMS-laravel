<?php

use App\Models\Book;
use App\Models\BookLanguage;
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create(Book::TABLE, function (Blueprint $table){
            $table->string(Book::KEY)->primary();
            $table->string('Title', 400);
            $table->string('Author')->default('غير معروف');
            $table->string('Publisher')->default('غير معروف');
            $table->string('ReleaseYear', 4)->nullable();
            $table->string('Source')->default('غير معروف');
            $table->integer('Price')->default(0);

            $table->float('Popularity')->default(0);
            $table->foreignId(Category::FOREIGN_KEY);
            $table->foreignId(BookLanguage::FOREIGN_KEY);
            $table->integer('TotalRentals')->default(0);
            $table->string('Isbn')->default('');

            $table->foreign(Category::FOREIGN_KEY)->references(Category::KEY)->on(Category::TABLE)->cascadeOnUpdate();
            $table->foreign(BookLanguage::FOREIGN_KEY)->references(BookLanguage::KEY)->on(BookLanguage::TABLE)->cascadeOnUpdate();

            if(Book::CREATED_AT) {
                $table->timestamp(Book::CREATED_AT)->default(Db::raw("CURRENT_TIMESTAMP()"));
            }
            if(Book::UPDATED_AT) {
                $table->timestamp(Book::UPDATED_AT)->default(Db::raw("CURRENT_TIMESTAMP()"));
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
        Schema::dropIfExists(Book::TABLE);
    }
}
