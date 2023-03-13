<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Tests\Validation\LoginUserValidation;

class LoginUserTest extends TestCase
{
    use LoginUserValidation;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = $this->createUser(Arr::only($this->data, ['username', 'roles']));
    }

    /** @test */
    public function login_page_can_be_rendered()
    {
        $res = $this->get(route('login'));

        $res->assertViewIs('auth.login')
            ->assertSeeText('Masuk');
    }

    /** @test */
    public function user_can_login()
    {
        $this->withExceptionHandling();
        $res = $this->post(route('login'), array_merge($this->data, ['password' => 'aaaaa']));

        $res->assertRedirect(route('home'));
        $this->assertAuthenticated();
    }

    /** @test */
    public function authenticated_user_can_logout()
    {
        $this->actingAs($this->user);
        $this->assertAuthenticated();

        $res = $this->post(route('logout'));
        $res->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
