<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Validation\UpdateProfileAndChangePasswordValidation;

class UpdateProfileAndChangePasswordTest extends TestCase
{
    use UpdateProfileAndChangePasswordValidation;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->user = $this->authenticatedUser(Arr::except($this->data, ['password', 'password_confirmation']));
    }

    /** @test */
    public function update_profile_page_can_be_rendered()
    {
        $res = $this->get(route('front-profile'));

        $res->assertViewIs('pages.frontend.profiles.edit-profile')
            ->assertSeeText('Profile');
    }

    /** @test */
    public function change_password_page_can_be_rendered()
    {
        $res = $this->get(route('front-change-password'));

        $res->assertViewIs('pages.frontend.profiles.password.edit-password')
            ->assertSeeText('Change Password');
    }

    /** @test */
    public function user_can_update_profile()
    {
        Storage::fake($this->directory);
        $file = UploadedFile::fake()->image('beatles.png');
        $data = $this->profileData(['name' => 'John Doe', 'username' => 'johndoe', 'image' => $file]);

        $res = $this->patch(route('update-profile'), $data);

        $res->assertRedirect(route('home'))
            ->assertSessionHas('success');
        $this->deleteDirectory($this->directory, $this->user->avatar);
    }

    /** @test */
    public function user_can_delete_existing_avatar()
    {
        Storage::fake($this->directory);
        $file = UploadedFile::fake()->image('beatles.png');
        $fileName = $file->getClientOriginalName();
        $this->user->update(['avatar' => $fileName]);
        Storage::putFileAs($this->directory, $file, $file->getClientOriginalName());

        $res = $this->post(route('delete-avatar'));

        $res->assertRedirect(route('front-profile'))
            ->assertSessionHas('success');
    }

    /** @test */
    public function user_can_change_password()
    {
        $res = $this->patch(route('update-password'), $this->passwords($this->currentPassword, 'abc123', 'abc123'));

        $res->assertRedirect(route('home'))
            ->assertSessionHas('success');
    }
}
