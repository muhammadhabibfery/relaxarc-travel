<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Arr;
use App\Notifications\VerifyEmails;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use Tests\Validation\RegisterUserValidation;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

class RegisterUserTest extends TestCase
{
    use RegisterUserValidation;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function register_page_can_be_rendered()
    {
        $res = $this->get(route('register'));

        $res->assertViewIs('auth.register')
            ->assertSee('Daftar');
    }

    /** @test */
    public function user_can_register()
    {
        $this->withExceptionHandling();
        Event::fake();
        Notification::fake();

        $res = $this->post(route('register'), $this->data);

        $res->assertValid()
            ->assertRedirect(route('login'));
        $user = User::first();
        $user->notify(new VerifyEmails);


        $this->assertDatabaseHas('users', Arr::except($this->data, ['password', 'password_confirmation']))
            ->assertDatabaseCount('users', 1);

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailVerificationNotification::class);
        Notification::assertSentTo($user, VerifyEmails::class);
    }
}
