<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\TravelPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class TravelGalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->image(storage_path('app/public/travel-galleries'), word: $this->faker->word() . '.png');
        $name = last(explode('\\', $name));

        return [
            'travel_package_id' => TravelPackage::factory(),
            'name' => $name,
            'slug' => Str::of($name)->slug(),
            'uploaded_by' => $this->faker->numberBetween(1, 2)
        ];
    }
}
