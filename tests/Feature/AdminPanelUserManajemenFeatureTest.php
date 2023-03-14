<?php

namespace Tests\Feature;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPanelUserManajemenFeatureTest extends TestCase
{
    private Collection $users;
    private User $userAdmin;
    private User $userInactive;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->userAdmin = $this->authenticatedUser();
        $this->users = $this->createUser(['roles' => ["ADMIN"]], 8);
        $this->userInactive = $this->createUser(['roles' => ["ADMIN", "SUPERADMIN"], 'status' => 'NONE']);
    }

    /** @test */
    public function user_menu_list_can_be_rendered()
    {
        $this->get(UserResource::getUrl('index'))
            ->assertSuccessful()
            ->assertSeeText(trans('List of user'));
    }

    /** @test */
    public function user_menu_list_can_show_list_of_users()
    {
        $users = $this->getListUsers();

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users);
    }

    /** @test */
    public function user_menu_list_can_search_user_by_username()
    {
        $user = $this->users->last();

        Livewire::test(ListUsers::class)
            ->searchTable($user->username)
            ->assertCanSeeTableRecords($this->users->where('username', $user->username))
            ->assertCanNotSeeTableRecords($this->users->where('username', '!==', $user->username));
    }

    /** @test */
    public function user_menu_list_can_filter_users_by_role()
    {
        $users = $this->getListUsers();
        $user = $this->userInactive;

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users)
            ->filterTable('roles', json_encode($user->roles))
            ->assertCanSeeTableRecords($users->where('roles', $user->role))
            ->assertCanNotSeeTableRecords($users->where('roles', '!==', $user->roles));
    }

    /** @test */
    public function user_menu_list_can_filter_users_by_status()
    {
        $users = $this->getListUsers();
        $user = $this->userInactive;

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users)
            ->filterTable('status', $user->status)
            ->assertCanSeeTableRecords($users->where('status', $user->status))
            ->assertCanNotSeeTableRecords($users->where('status', '!==', $user->status));
    }

    /** @test */
    public function user_menu_create_can_be_rendered()
    {
        $this->get(UserResource::getUrl('create'))
            ->assertSuccessful()
            ->assertSeeText(trans('Create user'));
    }

    /** @test */
    public function user_menu_create_can_create_new_user()
    {
        $data = User::factory()->make(['roles' => ["ADMIN"]]);

        Livewire::test(CreateUser::class)
            ->fillForm(array_merge($data->toArray(), ['roles' => head($data->roles)]))
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('users', $data->only(['name', 'username', 'email', 'phone']))
            ->assertDatabaseCount('users', 11);
    }

    /** @test */
    public function user_menu_create_the_rules_should_be_dispatched()
    {
        $data = User::factory()->create(['roles' => ["ADMIN"]]);

        Livewire::test(CreateUser::class)
            ->fillForm(array_merge($data->toArray(), ['roles' => head($data->roles)]))
            ->call('create')
            ->assertHasFormErrors(['email' => 'unique', 'phone' => 'unique']);
    }

    /** @test */
    public function user_menu_edit_can_be_rendered()
    {
        $this->get(UserResource::getUrl('edit', ['record' => $this->userInactive]))
            ->assertSuccessful()
            ->assertSeeText('Edit user');
    }

    /** @test */
    public function user_menu_edit_can_retrieve_data()
    {
        $user = $this->userInactive;

        Livewire::test(EditUser::class, ['record' => $user['username']])
            ->assertFormSet($user->toArray());
    }

    /** @test */
    public function user_menu_edit_can_edit_selected_user()
    {
        $user = $this->users->last();
        $newData = ['name' => 'John Lennon', 'username' => 'johnlennon', 'email' => 'johnlennon@beatles.com', 'roles' => ["ADMIN"], 'status' => 'ACTIVE'];

        Livewire::test(EditUser::class, ['record' => $user->username])
            ->fillForm(array_merge($user->toArray(), $newData))
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('users', Arr::except($newData, ['roles']))
            ->assertDatabaseMissing('users', $user->only(['name', 'username', 'email', 'status']));
    }

    /** @test */
    public function user_menu_view_can_be_rendered()
    {
        $user = $this->userInactive;

        $this->get(UserResource::getUrl('view', ['record' => $user]))
            ->assertSuccessful()
            ->assertSeeText(trans('Detail of user'));
    }

    /** @test */
    public function user_menu_view_can_retrieve_data_of_selected_user()
    {
        $user = $this->userInactive;
        $roles = count($user->roles) > 1 ? "Admin" : "Staff";
        $data = array_merge($user->toArray(), ['roles' => $roles]);

        Livewire::test(ViewUser::class, ['record' => $user->username])
            ->assertFormSet($data);
    }

    private function getListUsers(): Collection
    {
        return User::where('id', '!=', $this->userAdmin->id)
            ->get();
    }
}
