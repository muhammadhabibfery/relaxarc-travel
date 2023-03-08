<?php

namespace Database\Factories;

use App\Models\TravelPackage;
use App\Models\User;
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
        return [
            'travel_package_id' => TravelPackage::factory(),
            'user_id' => User::factory(),
            'total' => rand(1111111, 9999999),
            'invoice_number' => generateInvoiceNumber(),
            'status' => 'IN CART',
            'deleted_by' => null
        ];
    }
}
