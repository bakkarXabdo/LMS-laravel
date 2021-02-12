<?php

namespace Database\Factories;

use App\Models\RentalHistory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentalHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RentalHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = [
            'CustomerCardId' => rand(10000, 99000),
            'CustomerName' => $this->faker->name,
            'BookId' => rand(10000, 99000),
            'BookTitle' => $this->faker->name
        ];
        $data['RentalCreatedAt'] = rand(Carbon::parse('2021-02-01')->unix(), Carbon::parse('2021-02-10')->unix());
        $data['RentalExpiresAt'] = $data['RentalCreatedAt'] + rand(10, 20);
        $data['RentalReturnedAt'] = $data['RentalCreatedAt'] + rand(5, rand(5, rand(10, 30)));
        $data['RentalCreatedAt'] = Carbon::parse($data['RentalCreatedAt']);
        $data['RentalExpiresAt'] = Carbon::parse($data['RentalExpiresAt']);
        $data['RentalReturnedAt'] = Carbon::parse($data['RentalReturnedAt']);
        return $data;
    }
}
