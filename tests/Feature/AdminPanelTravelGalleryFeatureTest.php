<?php

namespace Tests\Feature;

use App\Filament\Resources\TravelGalleryResource;
use App\Filament\Resources\TravelGalleryResource\Pages\CreateTravelGallery;
use App\Filament\Resources\TravelGalleryResource\Pages\ListTravelGalleries;
use App\Filament\Resources\TravelGalleryResource\Pages\ViewTravelGallery;
use App\Models\TravelGallery;
use App\Models\TravelPackage;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

class AdminPanelTravelGalleryFeatureTest extends TestCase
{
    private User $userAdmin;
    private string $directory = 'travel-galleries';
    private string $table = 'travel_galleries';
    private Collection $travelPackagesAvailableDoesNotHaveTravelGallery;
    private $travelPackageAvailableHasTravelGalleries;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        Storage::fake($this->directory);
        $this->userAdmin = $this->authenticatedUser();

        $this->travelPackagesAvailableDoesNotHaveTravelGallery = $this->createTravelPackage(['date_departure' => now(config('app.timezone'))->addDay(), 'date_completion' => now(config('app.timezone'))->addDays(2), 'duration' => 2, 'price' => 500000, 'created_by' => $this->userAdmin->id], 2);
        TravelPackage::factory(['created_by' => $this->userAdmin->id, 'date_departure' => now(config('app.timezone'))->addDay(), 'date_completion' => now(config('app.timezone'))->addDays(2), 'duration' => 2])
            ->hasTravelGalleries(1)
            ->create();
        $this->deleteFiles();
        $this->travelPackageAvailableHasTravelGalleries = $this->getTravelPackagesHasTravelGalleries();
    }

    /** @test */
    public function travel_gallery_menu_list_can_be_rendered()
    {
        $this->get(TravelGalleryResource::getUrl())
            ->assertSuccessful()
            ->assertSeeText(trans('List of travel galleries'));
    }

    /** @test */
    public function travel_gallery_menu_list_can_show_list_of_travel_package_who_has_travel_galleries()
    {
        $travelPackageOnGoing = $this->createTravelPackage(['date_departure' => now(config('app.timezone'))->subDay(), 'date_completion' => now(config('app.timezone'))->addDays(1), 'duration' => 2, 'price' => 500000, 'created_by' => $this->userAdmin], 2);

        Livewire::test(ListTravelGalleries::class)
            ->assertCanSeeTableRecords($this->travelPackageAvailableHasTravelGalleries)
            ->assertCanNotSeeTableRecords($travelPackageOnGoing)
            ->assertCanNotSeeTableRecords($this->travelPackagesAvailableDoesNotHaveTravelGallery);
    }

    /** @test */
    public function travel_gallery_menu_list_can_search_travel_package_who_has_travel_galleries_by_title()
    {
        $title = $this->travelPackageAvailableHasTravelGalleries->last()->title;

        Livewire::test(ListTravelGalleries::class)
            ->searchTable($title)
            ->assertCanSeeTableRecords($this->travelPackageAvailableHasTravelGalleries->where('title', $title))
            ->assertCanNotSeeTableRecords($this->travelPackageAvailableHasTravelGalleries->where('title', '!==', $title));
    }

    /** @test */
    public function travel_galleries_menu_create_can_be_rendered()
    {
        $this->get(TravelGalleryResource::getUrl('create'))
            ->assertSuccessful()
            ->assertSeeText(trans('Create Travel Gallery'));
    }

    /** @test */
    public function travel_gallery_menu_create_can_create_new_travel_gallery()
    {
        $travelPackage = $this->travelPackagesAvailableDoesNotHaveTravelGallery->last();
        $image = UploadedFile::fake()->image('beatles.png');
        $image = ['name' => $image];
        $data = array_merge(['travel_package_id' => $travelPackage->id], $image);

        $res = Livewire::test(CreateTravelGallery::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoFormErrors();

        $image = $res->json()->payload['serverMemo']['data']['data']['name'][0];
        $image = last(explode('/', $image));

        $this->assertDatabaseHas($this->table, ['name' => $image]);
        $this->deleteDirectory($this->directory, $image);
    }

    /** @test */
    public function travel_gallery_menu_view_can_be_rendered()
    {
        $travelPackage = $this->travelPackageAvailableHasTravelGalleries->last();

        $this->get(TravelGalleryResource::getUrl('view', ['record' => $travelPackage]))
            ->assertSuccessful()
            ->assertSeeText(trans('List of travel galleries'));
    }

    /** @test */
    public function travel_gallery_menu_view_can_retrieve_data_selected_travel_package_available_who_has_travel_galleries()
    {
        $travelPackage = $this->travelPackageAvailableHasTravelGalleries->last();
        $travelGalleries = $travelPackage->travelGalleries;

        Livewire::test(ViewTravelGallery::class, ['record' => $travelPackage->slug])
            ->assertCanRenderTableColumn('slug')
            ->assertTableColumnStateSet('slug', $travelGalleries->first()->slug, record: $travelGalleries->first())
            ->assertTableColumnStateSet('slug', $travelGalleries->last()->slug, record: $travelGalleries->last());
    }

    /** @test */
    public function travel_gallery_menu_delete_can_delete_selected_travel_galleries()
    {
        $travelPackage = $this->travelPackageAvailableHasTravelGalleries->last();
        $travelGalleries = $travelPackage->travelGalleries;
        $this->assertDatabaseHas($this->table, $travelGalleries->first()->only(['name', 'slug']));
        $this->assertDatabaseHas($this->table, $travelGalleries->last()->only(['name', 'slug']));

        Livewire::test(ListTravelGalleries::class)
            ->callTableAction('delete', $travelPackage);

        $this->assertDatabaseMissing($this->table, $travelGalleries->first()->only(['name', 'slug']))
            ->assertDatabaseMissing($this->table, $travelGalleries->last()->only(['name', 'slug']));
    }

    private function deleteFiles(): void
    {
        $fileNames = TravelGallery::all()
            ->pluck('name')
            ->toArray();
        $this->deleteDirectory($this->directory, $fileNames);
    }

    private function getTravelPackagesHasTravelGalleries(): Collection
    {
        return TravelPackage::where('date_departure', '>', now(config('app.timezone')))
            ->has('travelGalleries')
            ->get();
    }
}
