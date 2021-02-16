<?php

use App\Models\RentalHistory;
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
        Schema::create((new RentalHistory)->getTable(), function (Blueprint $table) {
            $table->id((new RentalHistory)->getKeyName());
            $table->string('StudentId');
            $table->string('CustomerName');
            $table->string('BookId');
            $table->string('BookTitle');
            $table->timestamp('RentalCreatedAt');
            $table->timestamp('RentalExpiresAt');

            if(RentalHistory::CREATED_AT) {
                $table->timestamp(RentalHistory::CREATED_AT);
            }
            if(RentalHistory::UPDATED_AT) {
                $table->timestamp(RentalHistory::UPDATED_AT);
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
        Schema::dropIfExists((new RentalHistory())->getTable());
    }
}
