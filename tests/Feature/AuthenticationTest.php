<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
//    use RefreshDatabase;

    /** @test */
    public function login_screen_can_be_rendered()
    {
        $response = $this->get('/login')
            ->assertSee('Login');

        $response->assertStatus(200);
    }

    // are the errors being produced for...
    /** @test */
    public function email_is_required()
    {
        $this->post('/login', [
            'email' => null,
            'password' => 'password',
        ])->assertSessionHasErrors('email');
    }

    // are the errors being produced for...
    /** @test */
    public function password_is_required()
    {
        $this->post('/login', [
            'email' => 'henry@mail.com',
            'password' => null,
        ])->assertSessionHasErrors('password');
    }

    /** @test */
    public function users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /** @test */
    public function users_can_logout()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->post('/logout');
        $this->assertGuest();
    }

    /** @test */
    public function users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
