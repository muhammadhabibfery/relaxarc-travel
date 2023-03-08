<?php

namespace Tests\Validation;

use App\Models\User;

trait EmailVerificationValidation
{
    public User $userVerified;
    public User $userNotVerified;

    /** @test */
    public function user_should_be_authenticated()
    {
        $this->withExceptionHandling();

        $res = $this->get(route('verification.verify', $this->verifyData($this->userNotVerified->id, $this->userNotVerified->email)));

        $res->assertRedirect(route('login'));
    }

    /** @test */
    public function the_id_and_or_hash_params_should_be_match()
    {
        $this->withExceptionHandling();

        $res = $this->get(route('verification.verify', $this->verifyData(999, 'abc@gmail.com')));

        $res->assertNotFound();
    }

    /** @test */
    public function unverified_user_cannot_access_profile_route()
    {
        $this->withExceptionHandling();
        $this->actingAs($this->userNotVerified);

        $res = $this->get(route('front-profile'));
        $res->assertRedirect(route('verification.notice'));
    }

    /** @test */
    public function verified_user_cannot_resend_verify_link()
    {
        $this->withExceptionHandling();
        $this->actingAs($this->userVerified);

        $res = $this->post(route('verification.resend'));
        $res->assertRedirect(route('home'))
            ->assertSessionMissing('resent');
    }

    /** @test */
    public function verified_user_cannot_verify_twice()
    {
        $this->withExceptionHandling();
        $this->actingAs($this->userVerified);

        $res = $this->get(route('verification.verify', $this->verifyData($this->userVerified->id, $this->userVerified->email)));
        $res->assertRedirect(route('home'))
            ->assertSessionMissing('verifiedStatus');
    }

    private function verifyData(int $id, string $email): array
    {
        return ['id' => $id, 'hash' => sha1($email)];
        return ['id' => $id, 'hash' => $email];
    }
}
