<?php

namespace Tests\Feature;

use Illuminate\Auth\Events\Verified;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tests\Validation\EmailVerificationValidation;

class EmailVerificationTest extends TestCase
{
    use EmailVerificationValidation;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->withoutMiddleware(ValidateSignature::class);

        $this->userVerified = $this->createUser(['username' => 'johndoe', 'email' => 'johndoe@gmail.com', 'roles' => ["MEMBER"]]);
        $this->userNotVerified = $this->createUser(['username' => 'johnlennon', 'email' => 'johnlennon@gmail.com', 'email_verified_at' => null, 'roles' => ["MEMBER"]]);
    }

    /** @test */
    public function user_can_verify_email()
    {
        Event::fake();
        $this->actingAs($this->userNotVerified);

        $res = $this->get(route('verification.verify', $this->verifyData($this->userNotVerified->id, $this->userNotVerified->email)));

        $res->assertRedirect(route('home'))
            ->assertSessionHas('verifiedStatus');
        Event::assertDispatched(Verified::class);
    }

    /** @test */
    public function user_can_resend_verify_link()
    {
        $this->actingAs($this->userNotVerified);

        $res = $this->post(route('verification.resend'));
        $res->assertSessionHas('resent');
    }

    /** @test */
    public function verified_user_can_access_profile_route()
    {
        $this->withExceptionHandling();
        $this->actingAs($this->userVerified);

        $res = $this->get(route('front-profile'));

        $res->assertOk()
            ->assertViewIs('pages.frontend.profiles.edit-profile')
            ->assertSeeText('Form Profil');
    }
}
