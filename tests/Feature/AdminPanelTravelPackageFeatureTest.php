<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\TravelPackage;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\TravelPackageResource;
use App\Filament\Resources\TravelPackageResource\Pages\EditTravelPackage;
use App\Filament\Resources\TravelPackageResource\Pages\ListTravelPackages;
use App\Filament\Resources\TravelPackageResource\Pages\CreateTravelPackage;
use App\Filament\Resources\TravelPackageResource\Pages\ViewTravelPackage;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;

class AdminPanelTravelPackageFeatureTest extends TestCase
{
    private User $userAdmin;
    private string $table = 'travel_packages';

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->userAdmin = $this->authenticatedUser();
        $this->createTravelPackage(['date_departure' => now(config('app.timezone'))->addDay(), 'date_completion' => now(config('app.timezone'))->addDays(2), 'duration' => 2, 'price' => 500000, 'created_by' => $this->userAdmin]);
        $this->createTravelPackage(['date_departure' => now(config('app.timezone'))->subDay(), 'date_completion' => now(config('app.timezone'))->addDays(1), 'duration' => 2, 'price' => 500000, 'created_by' => $this->userAdmin]);
        $this->createTravelPackage(['date_departure' => now(config('app.timezone'))->subDays(3), 'date_completion' => now(config('app.timezone'))->subDay(), 'duration' => 2, 'price' => 500000, 'created_by' => $this->userAdmin]);
        $this->createTravelPackage(['date_departure' => now(config('app.timezone'))->addDay(), 'date_completion' => now(config('app.timezone'))->addDays(2), 'duration' => 2, 'price' => 500000, 'created_by' => $this->userAdmin, 'deleted_by' => $this->userAdmin, 'deleted_at' => now()->subMinute()]);
        $this->createTravelPackage(['date_departure' => now(config('app.timezone'))->subDay(), 'date_completion' => now(config('app.timezone'))->addDays(1), 'duration' => 2, 'price' => 500000, 'created_by' => $this->userAdmin, 'deleted_by' => $this->userAdmin, 'deleted_at' => now()->subMinute()]);
        $this->createTravelPackage(['date_departure' => now(config('app.timezone'))->subDays(3), 'date_completion' => now(config('app.timezone'))->subDay(), 'duration' => 2, 'price' => 500000, 'created_by' => $this->userAdmin, 'deleted_by' => $this->userAdmin, 'deleted_at' => now()->subMinute()]);
    }

    /** @test */
    public function travel_package_menu_list_can_be_rendered()
    {
        $this->get(TravelPackageResource::getUrl())
            ->assertSuccessful()
            ->assertSeeText(trans('List of travel packages'));
    }

    /** @test */
    public function travel_package_menu_list_can_show_list_of_travel_packages()
    {
        $travelPackages = $this->getTravelPackagesNotTrashed();

        Livewire::test(ListTravelPackages::class)
            ->assertCanSeeTableRecords($travelPackages);
    }

    /** @test */
    public function travel_package_menu_list_can_search_travel_packages_by_title_or_location()
    {
        $travelPackages = $this->getTravelPackagesNotTrashed();
        $title = $travelPackages->last()->title;
        // $location = $travelPackages->first()->location

        Livewire::test(ListTravelPackages::class)
            ->searchTable($title)
            ->assertCanSeeTableRecords($travelPackages->where('title', $title))
            ->assertCanNotSeeTableRecords($travelPackages->where('title', '!=', $title));
    }

    /** @test */
    public function travel_package_menu_list_can_filter_travel_packages_by_status()
    {
        $travelPackages = $this->getTravelPackagesNotTrashed();

        Livewire::test(ListTravelPackages::class)
            ->assertCanSeeTableRecords($travelPackages)
            ->filterTable('status', ['status' => '>'])
            ->assertCanSeeTableRecords($travelPackages->where('date_departure_status', 'AVAILABLE'))
            ->assertCanNotSeeTableRecords($travelPackages->where('date_departure_status', '!=', 'AVAILABLE'));
    }

    /** @test */
    public function admin_can_filter_trashed_travel_packages()
    {
        Livewire::test(ListTravelPackages::class)
            ->assertSee(__('tables::table.filters.trashed.label'))
            ->assertCanSeeTableRecords($this->getTravelPackagesNotTrashed())
            ->filterTable('trashed', false)
            ->assertCanSeeTableRecords($this->getTravelPackagesTrashed())
            ->assertCanNotSeeTableRecords($this->getTravelPackagesNotTrashed());
    }

    /** @test */
    public function staff_can_not_filter_trashed_travel_packages()
    {
        $this->userAdmin = $this->authenticatedUser(['roles' => ['ADMIN']]);

        Livewire::test(ListTravelPackages::class)
            ->assertDontSee(__('tables::table.filters.trashed.label'))
            ->assertCanSeeTableRecords($this->getTravelPackagesNotTrashed());
    }

    /** @test */
    public function travel_package_menu_create_can_be_rendered()
    {
        $this->get(TravelPackageResource::getUrl('create'))
            ->assertSuccessful()
            ->assertSeeText(trans('Create Travel Package'));
    }

    /** @test */
    public function travel_package_menu_create_can_create_new_travel_package()
    {
        $data = TravelPackage::factory()->make(['created_by' => $this->userAdmin->id, 'date_departure' => now(config('app.timezone'))->addDays(2)]);

        Livewire::test(CreateTravelPackage::class)
            ->fillForm($data->toArray())
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas($this->table, $data->only(['title', 'location', 'about']))
            ->assertDatabaseCount($this->table, 7);
    }

    /** @test */
    public function travel_package_menu_create_the_rules_should_be_dispatched()
    {
        $this->withExceptionHandling();
        $data = TravelPackage::factory()->make(['created_by' => $this->userAdmin->id, 'date_departure' => now(config('app.timezone'))->addDays(2)]);
        $newData = array_merge($data->toArray(), ['title' => $this->getTravelPackagesNotTrashed()->first()->title]);

        Livewire::test(CreateTravelPackage::class)
            ->fillForm($newData)
            ->call('create')
            ->assertHasFormErrors(['title' => 'unique']);
    }

    /** @test */
    public function travel_package_menu_edit_can_be_rendered_and_only_travel_package_available_can_be_updated()
    {
        $travelPackage = $this->getTravelPackagesNotTrashed()->where('date_departure_status', 'AVAILABLE')->first();

        $this->get(TravelPackageResource::getUrl('edit', $travelPackage))
            ->assertSuccessful()
            ->assertSeeText(trans('Edit travel package'));
    }

    /** @test */
    public function travel_package_menu_edit_can_retrieve_data_form_selected_travel_package_available()
    {
        $travelPackage = $this->getTravelPackagesNotTrashed()->where('date_departure_status', 'AVAILABLE')->first();
        $expectedData = array_merge($travelPackage->toArray(), ['date_departure' => Carbon::parse($travelPackage->date_departure, config('app.timezone'))->format('Y-m-d H:i:s')]);

        Livewire::test(EditTravelPackage::class, ['record' => $travelPackage->slug])
            ->assertFormSet($expectedData);
    }

    /** @test */
    public function travel_package_menu_edit_can_edit_selected_travel_package_available()
    {
        $travelPackage = $this->getTravelPackagesNotTrashed()->where('date_departure_status', 'AVAILABLE')->first();
        $data = TravelPackage::factory()->make(['created_by' => $this->userAdmin->id, 'date_departure' => now(config('app.timezone'))->addDays(2)]);

        Livewire::test(EditTravelPackage::class, ['record' => $travelPackage->slug])
            ->fillForm($data->toArray())
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas($this->table, $data->only(['title', 'location', 'about']))
            ->assertDatabaseMissing($this->table, $travelPackage->only(['title', 'location', 'about']));
    }

    /** @test */
    public function travel_package_menu_edit_can_not_edit_travel_package_expired_or_ongoing()
    {
        $this->withExceptionHandling();
        $travelPackage = $this->getTravelPackagesNotTrashed()->where('date_departure_status', 'EXPIRED')->first();

        $this->get(TravelPackageResource::getUrl('edit', $travelPackage))
            ->assertForbidden();
    }

    /** @test */
    public function admin_can_not_edit_selected_travel_package_created_by_staff()
    {
        $this->withExceptionHandling();
        $userStaff = $this->createUser(['roles' => ['STAFF']]);
        $travelPackage = $this->createTravelPackage(['date_departure' => now(config('app.timezone'))->addDays(2), 'created_by' => $userStaff->id]);

        $this->get(TravelPackageResource::getUrl('edit', ['record' => $travelPackage->slug]))
            ->assertForbidden();
    }

    /** @test */
    public function travel_package_menu_delete_can_delete_selected_travel_package()
    {
        $travelPackage = $this->getTravelPackagesNotTrashed()->where('date_departure_status', 'EXPIRED')->first();

        Livewire::test(ListTravelPackages::class)
            ->callTableAction(DeleteAction::class, $travelPackage);


        $this->assertDatabaseMissing($this->table, $travelPackage->only(['name', 'location', 'about']));
    }

    /** @test */
    public function admin_can_not_delete_selected_travel_package_created_by_staff()
    {
        $userStaff = $this->createUser(['roles' => ['STAFF']]);
        $travelPackage = $this->createTravelPackage(['date_departure' => now(config('app.timezone'))->addDays(2), 'created_by' => $userStaff->id]);

        Livewire::test(ListTravelPackages::class)
            ->assertTableActionHidden('delete', $travelPackage);
    }

    /** @test */
    public function travel_package_menu_view_can_be_rendered()
    {
        $travelPackage = $this->getTravelPackagesNotTrashed()->first();

        $this->get(TravelPackageResource::getUrl('view', ['record' => $travelPackage]))
            ->assertSuccessful()
            ->assertSeeText(trans('Detail travel packages'));
    }

    /** @test */
    public function travel_package_menu_view_can_retrieve_data_from_selected_travel_package()
    {
        $travelPackage = $this->getTravelPackagesNotTrashed()->where('date_departure_status', 'AVAILABLE')->first();
        $expectedData = array_merge($travelPackage->toArray(), ['date_departure' => Carbon::parse($travelPackage->date_departure, config('app.timezone'))->format('Y-m-d H:i:s'), 'duration' => $travelPackage->duration . ' Hari', 'price' => currencyFormat($travelPackage->price), 'created_by' => $this->userAdmin->name]);

        Livewire::test(ViewTravelPackage::class, ['record' => $travelPackage->slug])
            ->assertFormSet($expectedData);
    }

    /** @test */
    public function admin_can_restore_deleted_available_travel_package()
    {
        $travelPackage = $this->getTravelPackagesTrashed()
            ->where('date_departure_status', 'AVAILABLE')->first();

        Livewire::test(ListTravelPackages::class)
            ->callTableAction(RestoreAction::class, $travelPackage);

        $this->assertTrue($this->getTravelPackagesTrashed()->count() == 2);
    }

    /** @test */
    public function admin_can_not_restore_deleted_expired_travel_package()
    {
        $travelPackage = $this->getTravelPackagesTrashed()
            ->where('date_departure_status', 'EXPIRED')->first();

        Livewire::test(ListTravelPackages::class)
            ->assertTableActionHidden('restore', $travelPackage);
    }

    /** @test */
    public function staff_can_not_restore_travel_package()
    {
        $this->userAdmin = $this->authenticatedUser(['roles' => ['ADMIN']]);

        $travelPackage = $this->getTravelPackagesTrashed()
            ->where('date_departure_status', 'AVAILABLE')->first();

        Livewire::test(ListTravelPackages::class)
            ->assertTableActionHidden('restore', $travelPackage);
    }

    /** @test */
    public function admin_can_force_delete_deleted_expired_travel_package()
    {
        $travelPackage = $this->getTravelPackagesTrashed()
            ->where('date_departure_status', 'EXPIRED')->first();

        Livewire::test(ListTravelPackages::class)
            ->callTableAction(ForceDeleteAction::class, $travelPackage);

        $this->assertTrue($this->getTravelPackagesTrashed()->count() == 2);
    }

    /** @test */
    public function admin_can_not_force_delete_deleted_available_travel_package()
    {
        $travelPackage = $this->getTravelPackagesTrashed()
            ->where('date_departure_status', 'AVAILABLE')->first();

        Livewire::test(ListTravelPackages::class)
            ->assertTableActionHidden('forceDelete', $travelPackage);
    }

    /** @test */
    public function staff_can_not_force_delete_deleted_travel_package()
    {
        $this->userAdmin = $this->authenticatedUser(['roles' => ['ADMIN']]);
        $travelPackage = $this->getTravelPackagesTrashed()
            ->where('date_departure_status', 'EXPIRED')->first();

        Livewire::test(ListTravelPackages::class)
            ->assertTableActionHidden('forceDelete', $travelPackage);
    }

    private function getTravelPackagesNotTrashed(): Collection
    {
        return TravelPackage::all();
    }

    private function getTravelPackagesTrashed(): Collection
    {
        return TravelPackage::onlyTrashed()
            ->get();
    }

    public function getAllTravelPackages(): Collection
    {
        return TravelPackage::withTrashed()
            ->get();
    }
}
