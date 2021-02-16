<?php

namespace Database\Factories;

use App\Models\BookCopy;
use App\Models\Student;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class RentalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rental::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $c = DB::transaction(function(){
            $c = BookCopy::query()->whereDoesntHave('rental')->first();
            $c->Rented = 1;
            return $c;
        });
        $cu = Student::query()->inRandomOrder()->first();
        return [
            "BookCopyId" => $c->getKey(),
            "BookId" => $c->book->getKey(),
            "CustomerId" => $cu->getKey(),
            "Expires" => Carbon::now()->addDays(15)
        ];
    }
}
