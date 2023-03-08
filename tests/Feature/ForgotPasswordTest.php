<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\ResetPasswordNotifcation;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    public User $user;
    public string $email = 'johnlennon@beatles.com';

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = $this->createUser(['email' => $this->email, 'roles' => '["MEMBER"]']);
    }

    /** @test */
    public function forgot_password_page_can_be_rendered()
    {
        $res = $this->get(route('password.request'));

        $res->assertViewIs('auth.passwords.email')
            ->assertSeeText('Reset Password');
    }

    /** @test */
    public function the_email_field_must_have_an_existing_user()
    {
        $this->withExceptionHandling();

        $res = $this->post(route('password.email'), ['email' => 'paul@beatles.com']);

        $res->assertInvalid('email')
            ->assertSessionMissing('status');
    }

    /** @test */
    public function user_can_send_reset_password_link()
    {
        Notification::fake();

        $res = $this->post(route('password.email'), ['email' => $this->email]);

        $res->assertValid()
            ->assertSessionHas('status');
        Notification::assertSentTo($this->user, ResetPasswordNotifcation::class);
    }
}
