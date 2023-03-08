<?php

namespace Tests\Feature;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Facades\Password;
use Tests\Validation\ResetPasswordValidation;

class ResetPasswordTest extends TestCase
{
    use ResetPasswordValidation;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = $this->createUser(['email' => 'johnlennon@gmail.com']);
        $this->token = Password::createToken($this->user);
    }

    /** @test */
    public function reset_password_page_can_be_rendered()
    {
        $res = $this->get(route('password.reset', ['email' => $this->user->email, 'token' => 'abc123']));

        $res->assertViewIs('auth.passwords.reset')
            ->assertSeeText('Reset Password');
    }

    /** @test */
    public function user_can_reset_password()
    {
        Event::fake();
        $newPassword = 'secret12345';

        $res = $this->post(route('password.update'), $this->resetPasswordData($this->user->email, $newPassword, $newPassword, $this->token));

        $res->assertRedirect(route('login'))
            ->assertValid()
            ->assertSessionHas('status');

        Event::assertDispatched(PasswordReset::class);

        $this->assertTrue(Hash::check($newPassword, $this->user->fresh()->password));
        $this->assertDatabaseMissing('password_resets', ['email' => $this->user->email, 'token' => $this->token]);
    }
}
