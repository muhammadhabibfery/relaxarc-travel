<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TravelPackage;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create();

        User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@relaxarc.com',
                'email_verified_at' => now(),
                'password' => Hash::make('aaaaa'), // password
                'remember_token' => Str::random(10),
                'username' => 'admin',
                'roles' => '["ADMIN"]',
                'phone' => '0897654322',
                'address' => 'jl.in dulu',
                'status' => 'ACTIVE',
            ]
        );
        User::create(
            [
                'name' => 'Member',
                'email' => 'member@relaxarc.com',
                'email_verified_at' => now(),
                'password' => Hash::make('aaaaa'), // password
                'remember_token' => Str::random(10),
                'username' => 'member',
                'roles' => '["MEMBER"]',
                'phone' => '0897654323',
                'address' => 'jl.in dulu aja',
                'status' => 'ACTIVE',
            ]
        );
        User::create(
            [
                'name' => 'Fery leonardo',
                'email' => 'feryleonardo@gmails.com',
                'email_verified_at' => now(),
                'password' => Hash::make('aaaaa'), // password
                'remember_token' => Str::random(10),
                'username' => 'feryleonardo',
                'roles' => '["MEMBER"]',
                'phone' => '0897654324',
                'address' => 'jl.in dulu sih',
                'status' => 'ACTIVE',
            ]
        );

        TravelPackage::factory(100)->create();

        Transaction::factory(10)->create();

        TransactionDetail::factory(20)->create();
    }
}
