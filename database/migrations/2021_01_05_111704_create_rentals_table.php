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
        $student = new Student;
        $book = new Book;
        $copy = new BookCopy;
        $rental = new Rental;
        Schema::create($rental->getTable(), function (Blueprint $table) use ($student, $book, $copy, $rental) {
            $table->id($rental->getKeyName());
            $table->foreignId('StudentId');
            $table->string('BookId');
            $table->string('BookCopyId');
            $table->timestamp('ExpiresAt', 6);
            $table->timestamp('ReturnedAt', 6);

            $table->foreign('StudentId')->references($student->getKeyName())->on($student->getTable())->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('BookId')->references($book->getKeyName())->on($book->getTable())->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('BookCopyId')->references($copy->getKeyName())->on($copy->getTable())->cascadeOnUpdate()->restrictOnDelete();
            if(Rental::CREATED_AT) {
                $table->timestamp(Rental::CREATED_AT);
            }
            if(Rental::UPDATED_AT) {
                $table->timestamp(Rental::UPDATED_AT);
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
        Schema::dropIfExists((new Rental)->getTable());
    }
}
