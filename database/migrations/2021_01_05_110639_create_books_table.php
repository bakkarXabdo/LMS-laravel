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
        $lang = new BookLanguage();
        $cat = new Category();
        $book = new Book;
        Schema::create($book->getTable(), function (Blueprint $table) use ($lang, $cat, $book) {
            $table->string($book->getKeyName())->primary();
            $table->string('Title', 400);
            $table->string('Author')->default('Unknown');
            $table->string('Publisher')->default('Unknown');
            $table->year('ReleaseYear')->nullable();
            $table->integer('copies')->default(0);
            $table->integer('Price')->default(0);

            $table->float('Popularity')->default(0);
            $table->foreignId('CategoryId');
            $table->foreignId('LanguageId');
            $table->integer('TotalRentals')->default(0);
            $table->string('Isbn')->default('');

            $table->foreign('CategoryId')->references($cat->getKeyName())->on($cat->getTable())->cascadeOnUpdate();
            $table->foreign('LanguageId')->references($lang->getKeyName())->on($lang->getTable())->cascadeOnUpdate();

            if($book::CREATED_AT) {
                $table->timestamp($book::CREATED_AT)->default(DB::raw('NOW()'));
            }
            if($book::UPDATED_AT) {
                $table->timestamp($book::UPDATED_AT)->default(DB::raw('NOW()'));
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
        Schema::dropIfExists((new Book)->getTable());
    }
}
