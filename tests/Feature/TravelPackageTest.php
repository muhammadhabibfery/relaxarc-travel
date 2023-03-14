<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TravelGallery;
use Illuminate\Support\Facades\Storage;

class TravelPackageTest extends TestCase
{
    private User $user;
    private string $directory = 'travel-galleries';

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->user =  $this->createUser();
    }

    /** @test */
    public function list_of_travel_packages_page_can_be_rendered()
    {
        $travelPackages = $this->createTravelPackage(['created_by' => $this->user->id, 'date_departure' => now(config('app.timezone'))->addDay(), 'date_completion' => now(config('app.timezone'))->addDays(2), 'duration' => 2], 5);

        $res = $this->get(route('travel-packages.front.index'));

        $res->assertViewIs('pages.frontend.travel-packages-index')
            ->assertSeeText('Paket Travel')
            ->assertSeeText($travelPackages->pluck('title')->toArray());
    }

    /** @test */
    public function detail_of_travel_package_page_can_be_rendered()
    {
        Storage::fake($this->directory);
        $travelPackage = $this->createTravelPackage(['created_by' => $this->user->id], hasTravelGalleries: 1);

        $res = $this->get(route('travel-packages.front.detail', $travelPackage->slug));

        $res->assertViewIs('pages.frontend.travel-packages-detail')
            ->assertSeeText($travelPackage->only(['title', 'location']))
            ->assertSeeText($travelPackage->getDateDepartureWithDayAttribute())
            ->assertSeeText(formatTravelPackageDuration($travelPackage->duration, app()->getLocale()))
            ->assertSeeText('Rp. ' . number_format($travelPackage->price, 0, '.', '.'));
        $this->deleteDirectory($this->directory, TravelGallery::first()->name);
    }
}
