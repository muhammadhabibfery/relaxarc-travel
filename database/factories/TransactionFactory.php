<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\TravelPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $travelPackage = TravelPackage::findOrFail($this->faker->numberBetween(1, 3));
        return [
            'travel_package_id' => $travelPackage->id,
            'user_id' => 3,
            'total' => $travelPackage->price * 2,
            'invoice_number' => "RelaxArc-" . date('djy') . Str::random(16),
            'status' => $this->faker->randomElement(['IN CART', 'PENDING', 'SUCCESS', 'FAILED', 'CANCEL']),
            'created_by' => 3,
        ];
    }
}
