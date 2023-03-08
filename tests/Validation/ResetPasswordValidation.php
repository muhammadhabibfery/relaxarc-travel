<?php

namespace Tests\Validation;

use App\Models\User;

trait ResetPasswordValidation
{
    public User $user;
    public string $token;

    /** @test */
    public function the_email_field_must_have_an_existing_user()
    {
        $this->withExceptionHandling();

        $res = $this->post(route('password.update'), $this->resetPasswordData('paul@beatles.com', 'abcdef', 'abcdef', 'abc123'));

        $res->assertInvalid('email')
            ->assertSessionMissing('status');
    }

    /** @test */
    public function the_password_field_should_be_follow_password_rules()
    {
        $this->withExceptionHandling();

        $res = $this->post(route('password.update'), $this->resetPasswordData($this->user->email, 'abc', 'aabb', 'abc123'));

        $res->assertInvalid('password')
            ->assertSessionMissing('status');
    }

    /** @test */
    public function the_token_field_should_be_match()
    {
        $this->withExceptionHandling();

        $res = $this->post(route('password.update'), $this->resetPasswordData($this->user->email, 'secret123', 'secret123', 'abc1234'));

        $res->assertInvalid('email')
            ->assertSessionMissing('status');
    }

    private function resetPasswordData(string $email, string $password, string $passwordConfirmation, string $token): array
    {
        return [
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
            'token' => $token,
        ];
    }
}
