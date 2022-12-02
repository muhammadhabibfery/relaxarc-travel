<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $transaction = Transaction::findOrFail($this->faker->numberBetween(1, 5));
        $user = User::findOrFail($this->faker->numberBetween(3, 4));
        return [
            'transaction_id' => $transaction->id,
            'username' => $user->username,
            'created_by' => 3,
        ];
    }
}
