<?php

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Rental;
use App\Models\Student;
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
        Schema::create(Rental::TABLE, function (Blueprint $table){
            $table->id(Rental::KEY);
            $table->foreignId(Student::FOREIGN_KEY);
            $table->string(Book::FOREIGN_KEY);
            $table->string(BookCopy::FOREIGN_KEY);

            $table->foreign(Student::FOREIGN_KEY)->references(Student::KEY)->on(Student::TABLE)->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign(Book::FOREIGN_KEY)->references(Book::KEY)->on(Book::TABLE)->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign(BookCopy::FOREIGN_KEY)->references(BookCopy::KEY)->on(BookCopy::TABLE)->cascadeOnUpdate()->restrictOnDelete();

            $table->timestamp('ExpiresAt', 6);
            if(Rental::CREATED_AT) {
                $table->timestamp(Rental::CREATED_AT)->default(DB::raw("CURRENT_TIMESTAMP()"));
            }
            if(Rental::UPDATED_AT) {
                $table->timestamp(Rental::UPDATED_AT)->default(DB::raw("CURRENT_TIMESTAMP()"));
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
        Schema::dropIfExists(Rental::TABLE);
    }
}
