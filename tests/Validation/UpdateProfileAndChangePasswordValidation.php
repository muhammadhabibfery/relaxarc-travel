<?php

namespace Tests\Validation;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UpdateProfileAndChangePasswordValidation
{
    public User $user;
    public string $currentPassword = 'aaaaa';
    public string $directory = 'avatars';

    public array $data =
    [
        'name' => 'John Lennon',
        'username' => 'johnlennon',
        'email' => 'jl@gmail.com',
        'phone' => null,
        'address' => null,
        'roles' => ["MEMBER"],
    ];

    /** @test */
    public function username_email_phone_fields_should_be_unique()
    {
        $this->withExceptionHandling();
        $otherUser = $this->createUser(['address' => 'daldladkawdkddada']);
        $data = array_merge(
            $this->user->toArray(),
            Arr::only($otherUser->toArray(), ['name', 'username', 'phone', 'address', 'email'])
        );

        $res = $this->patch(route('update-profile'), $data);

        $res->assertInvalid(['username', 'phone', 'email']);
    }

    /** @test */
    public function image_field_should_contains_image_file()
    {
        $this->withExceptionHandling();
        Storage::fake($this->directory);
        $file = UploadedFile::fake()->create('beatles.pdf', 100);
        $data = $this->profileData(['image' => $file]);

        $res = $this->patch(route('update-profile'), $data);

        $res->assertInvalid('image');
    }

    /** @test */
    public function image_field_should_follow_image_rules()
    {
        $this->withExceptionHandling();
        Storage::fake($this->directory);
        $file = UploadedFile::fake()->image('beatles.png')->size(3000);
        $data = $this->profileData(['image' => $file]);

        $res = $this->patch(route('update-profile'), $data);

        $res->assertInvalid('image');
    }

    /** @test */
    public function current_password_field_must_be_correct()
    {
        $this->withExceptionHandling();

        $res = $this->patch(route('update-password'), $this->passwords('abc123', 'abc234', 'abc234'));

        $res->assertInvalid('current_password');
    }

    /** @test */
    public function new_password_field_should_follow_the_password_rules()
    {
        $this->withExceptionHandling();

        $res = $this->patch(route('update-password'), $this->passwords($this->currentPassword, 'abc', 'abc'));

        $res->assertInvalid('new_password');
    }

    /** @test */
    public function new_password_field_should_be_match_with_new_password_confirmation_field()
    {
        $this->withExceptionHandling();

        $res = $this->patch(route('update-password'), $this->passwords($this->currentPassword, 'abc123', 'abc'));

        $res->assertInvalid('new_password');
    }

    /** @test */
    public function new_password_field_and_current_password_field_must_be_different()
    {
        $this->withExceptionHandling();

        $res = $this->patch(route('update-password'), $this->passwords($this->currentPassword, $this->currentPassword, $this->currentPassword));

        $res->assertInvalid('new_password');
    }

    private function profileData(array $additionalData): array
    {
        $user = $this->user->fill(['phone' => '12345678901', 'address' => 'adadaowdwidjawdjaiowd'])->toArray();

        return array_merge($user, $additionalData);
    }

    private function passwords(string $currentPassword, string $newPassword, string $newPasswordConfirmation): array
    {
        return [
            'current_password' => $currentPassword,
            'new_password' => $newPassword,
            'new_password_confirmation' => $newPasswordConfirmation,
        ];
    }
}
