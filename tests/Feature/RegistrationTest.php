<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registration_screen_can_be_rendered()
    {
        $response = $this->get('/register')
            ->assertSee('Register');

        $response->assertStatus(200);
    }

    // are the errors being produced for...
    /** @test */
    public function name_is_required()
    {
        $this->post('/register', [
            'name' => null,
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors('name');
    }

    // are the errors being produced for...
    /** @test */
    public function email_is_required()
    {
        $this->post('/register', [
            'name' => 'jack',
            'email' => null,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors('email');
    }

    // are the errors being produced for...
    /** @test */
    public function password_is_required()
    {
        $this->post('/register', [
            'name' => 'jack',
            'email' => 'henry@mail.com',
            'password' => null,
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors('password');
    }

    // are the errors being produced for...
    /** @test */
    public function passwords_must_match()
    {
        $this->post('/register', [
            'name' => 'jack',
            'email' => 'henry@mail.com',
            'password' => 'assword',
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors('password');
    }

    // created, authenticated, and redirected to HOME
    /** @test */
    public function new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
