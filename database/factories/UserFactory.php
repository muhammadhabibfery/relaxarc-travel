<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Super Admin',
            'email' => 'superAdmin@relaxarc.com',
            'email_verified_at' => now(),
            'password' => Hash::make('aaaaa'), // password
            'remember_token' => Str::random(10),
            'username' => 'superadmin',
            'roles' => '["ADMIN", "SUPERADMIN"]',
            'phone' => '0897654321',
            'address' => 'jl.in ajaa',
            'status' => 'ACTIVE',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    // public function unverified()
    // {
    //     return $this->state(function (array $attributes) {
    //         return [
    //             'email_verified_at' => null,
    //         ];
    //     });
    // }
}
