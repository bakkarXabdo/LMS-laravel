<?php

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\RentalHistory;
use App\Models\Student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(RentalHistory::TABLE, function (Blueprint $table) {
            $table->id(RentalHistory::KEY);
            $table->string(Student::FOREIGN_KEY);
            $table->string(BookCopy::FOREIGN_KEY);
            $table->string(Book::FOREIGN_KEY);

            $table->string('StudentName');
            $table->string('BookTitle');
            $table->timestamp('RentalCreatedAt');
            $table->timestamp('RentalExpiresAt');

            $table->string('CreatedBy')->nullable()->default('غير معروف');
            $table->string('ReturnedBy')->nullable()->default('غير معروف');

            if(RentalHistory::CREATED_AT) {
                $table->timestamp(RentalHistory::CREATED_AT)->default(DB::raw("CURRENT_TIMESTAMP()"));
            }
            if(RentalHistory::UPDATED_AT) {
                $table->timestamp(RentalHistory::UPDATED_AT)->default(DB::raw("CURRENT_TIMESTAMP()"));
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
        Schema::dropIfExists(RentalHistory::TABLE);
    }
}
