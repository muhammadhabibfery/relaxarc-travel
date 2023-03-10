<?php

namespace Tests\Feature;

use App\Filament\Resources\ProfileResource;
use App\Filament\Resources\ProfileResource\Pages\CreateProfile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPanelProfileFeatureTest extends TestCase
{
    private User $userAdmin;
    private string $directory = 'avatars';

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        Session::setDefaultDriver('array');

        $this->userAdmin = $this->authenticatedUser();
    }

    /** @test */
    public function profile_menu_can_be_rendered()
    {
        $this->get(ProfileResource::getUrl())
            ->assertSuccessful()
            ->assertSeeText($this->userAdmin->name);
    }

    /** @test */
    public function profile_menu_can_retrieve_data()
    {
        Livewire::test(CreateProfile::class)
            ->assertFormSet($this->userAdmin->only(['name', 'username', 'email', 'phone']));
    }

    /** @test */
    public function profile_menu_validation_rules_should_be_dispatched()
    {
        $this->withExceptionHandling();
        $user = $this->createUser(['username' => 'johnlennon', 'email' => 'johnlennon@beatles.com', 'phone' => '12344567890']);
        $data = $user->only(['username', 'email', 'phone']);

        Livewire::test(CreateProfile::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasFormErrors(['email' => 'unique', 'phone' => 'unique']);
    }

    /** @test */
    public function profile_menu_can_update_profile()
    {
        $data = $this->newData();

        Livewire::test(CreateProfile::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('users', collect($data)->only(['username', 'email', 'phone'])->toArray());
    }

    /** @test */
    public function profile_menu_can_upload_avatar()
    {
        Storage::fake($this->directory);
        $image = UploadedFile::fake()->image('beatles.png');
        $image = ['avatar' => $image];
        $data = $this->newData($image);

        $res = Livewire::test(CreateProfile::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoFormErrors();

        $image = $res->json()->payload['serverMemo']['data']['data']['avatar'][0];

        $this->assertDatabaseHas('users', ['avatar' => $image]);
        $this->deleteDirectory($this->directory, last(explode('/', $image)));
    }

    /** @test */
    public function profile_menu_can_change_password()
    {
        $field = 'password_hash_' . Auth::getDefaultDriver();
        $this->withSession([$field => $this->userAdmin->getAuthPassword()]);
        $newPassword = 'abc123';
        $passwordData = ['current_password' => 'aaaaa', 'new_password' => $newPassword, 'new_password_confirmation' => $newPassword];
        $data = $this->newData($passwordData);

        Livewire::test(CreateProfile::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoFormErrors()
            ->assertSessionHas([$field => $this->userAdmin->fresh()->getAuthPassword()]);

        Hash::check($newPassword, $this->userAdmin->fresh()->getAuthPassword());
    }

    private function newData(?array $additionalData = null): array
    {
        $data = array_merge(
            $this->userAdmin->toArray(),
            ['username' => 'johnlennon', 'email' => 'johnlennon@beatles.com', 'phone' => '12344567890']
        );

        if ($additionalData) $data = array_merge($data, $additionalData);

        return $data;
    }
}
