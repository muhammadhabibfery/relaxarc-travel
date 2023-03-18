<?php

namespace Tests;

use App\Models\TravelPackage;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * Create a user instance.
     *
     * @param  array $data
     * @param  int $count
     * @return User|Collection
     */
    public function createUser(?array $data = [], ?int $count = 1): User|Collection
    {
        $users = User::factory()->count($count)->create($data);

        return $count < 2 ? $users->first() : $users;
    }

    /**
     * Create authenticated user.
     *
     * @param  array $data
     * @return User
     */
    public function authenticatedUser(?array $data = []): User
    {
        $user = $this->createUser($data);
        $this->actingAs($user);
        return $user;
    }

    /**
     * Create travel package(s).
     *
     * @param  array $data
     * @param  int $count
     * @param  int $hasTravelGalleries
     * @return TravelPackage|Collection
     */
    public function createTravelPackage(?array $data = [], ?int $count = 1, ?int $hasTravelGalleries = null): TravelPackage|Collection
    {
        if ($hasTravelGalleries)
            $travelPackages = TravelPackage::factory()
                ->count($count)
                ->hasTravelGalleries($hasTravelGalleries)
                ->create($data);

        $travelPackages = TravelPackage::factory()->count($count)->create($data);

        return $count < 2 ? $travelPackages->first() : $travelPackages;
    }

    public function deleteDirectory(string $directory, string|array $fileName, ?bool $delete = false): void
    {
        if ($delete) {
            Storage::disk($directory)->assertMissing($fileName);
        } else {
            if (is_array($fileName)) {
                foreach ($fileName as $fn) {
                    Storage::disk($directory)->exists($fn);
                    Storage::delete("$directory/$fn");
                }
            } else {
                Storage::disk($directory)->exists($fileName);
                Storage::delete("$directory/$fileName");
            }
        }
    }
}
