<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TravelPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = "{$this->faker->city()} {$this->faker->numberBetween(1, 100000)}";
        return [
            'title' => $title,
            'slug' => Str::of($title)->slug(),
            'location' => $this->faker->country(),
            'about' => $this->faker->paragraph(3),
            'featured_event' => "{$this->faker->randomElement(['makan', 'minum', 'bbq', 'karaoke'])},{$this->faker->randomElement(['makan', 'minum', 'bbq', 'karaoke'])}",
            'language' => $this->faker->randomElement(['indonesia,', 'english', 'arabic']),
            'foods' => "{$this->faker->randomElement(['Nasi Uduk', 'Nasi Goreng', 'gado-gado', 'lontong sayur'])},{$this->faker->randomElement(['Nasi Uduk', 'Nasi Goreng', 'gado-gado', 'lontong sayur'])}",
            'date_departure' => $this->faker->dateTimeBetween('-1week', '+1 week', 'Asia/Jakarta'),
            'duration' => "{$this->faker->numberBetween(1, 7)}D",
            'type' => $this->faker->randomElement(['Open Trip', 'Private Group']),
            'price' => $this->faker->numberBetween(250000, 750000),
            'created_by' => $this->faker->numberBetween(1, 2)
        ];
    }
}
