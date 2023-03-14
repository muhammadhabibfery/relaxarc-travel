<?php

namespace Tests\Feature;

use App\Models\TravelGallery;
use App\Models\TravelPackage;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeTest extends TestCase
{
    private TravelPackage $travelPackage;
    private string $directory = 'travel-galleries';

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        Storage::fake($this->directory);
        $this->createUser();
        $this->travelPackage = TravelPackage::factory(['created_by' => 1, 'date_departure' => now(config('app.timezone'))->addDay(), 'date_completion' => now(config('app.timezone'))->addDays(2), 'duration' => 2,])
            ->hasTravelGalleries(1)
            ->create();
        TravelPackage::factory(['created_by' => 1])
            ->create();
    }

    /** @test */
    public function home_page_can_be_rendered()
    {
        $res = $this->get(route('home'));

        $res->assertViewIs('pages.frontend.home')
            ->assertSeeText($this->travelPackage->title);
        $this->deleteDirectory($this->directory, TravelGallery::first()->name);
    }
}
