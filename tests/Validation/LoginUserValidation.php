<?php

namespace Tests\Validation;

use Illuminate\Support\Arr;

trait LoginUserValidation
{
    public array $data = [
        'username' => 'johnlennon',
        'password' => 'secret123',
        'roles' => ["MEMBER"]
    ];

    /** @test */
    public function all_fields_are_required()
    {
        $this->withExceptionHandling();

        $res = $this->post(route('login'), []);

        $res->assertInvalid(['username', 'password']);
    }

    /** @test */
    public function the_credentials_does_not_match()
    {
        $this->withExceptionHandling();

        $res = $this->post(route('login'), Arr::except($this->data, ['roles']));

        $res->assertInvalid(['username']);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_logout()
    {
        $this->withExceptionHandling();

        $res = $this->post(route('logout'));

        $res->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
