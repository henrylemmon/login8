<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $length256 = '1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111@.comX';

    /** @test */
    public function logged_in_non_admin_cannot_access_admin_routes()
    {
        $this->signIn();
        $user = User::factory()->create();
        $this->get(route('admin.users.index'))
            ->assertSessionHas('denied');
        $this->get(route('admin.users.create'))
            ->assertSessionHas('denied');
        $this->post(route('admin.users.store', 1))
            ->assertSessionHas('denied');
        $this->get(route('admin.users.edit', $user->id))
            ->assertSessionHas('denied');
        $this->patch(route('admin.users.update', $user->id), [])
            ->assertSessionHas('denied');
        $this->delete(route('admin.users.index', 1))
            ->assertSessionHas('denied');
    }

    /** @test */
    public function create_user_screen_can_be_rendered_by_signed_in_admin()
    {
        $this->signInAdmin();

        $this->get(route('admin.users.create'))
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_be_created()
    {
        $this->signInAdmin();

        $this->post(route('admin.users.store'), $user = [
            'name' => 'henry',
            'email' => 'henry@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
           'email' => $user['email']
        ]);
    }

    /** @test */
    public function creating_a_user_requires_a_name()
    {
        $this->signInAdmin();

        $this->post(route('admin.users.store'), [
            'name' => null,
            'email' => 'henry@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function creating_user_name_must_be_255_or_less()
    {
        $this->signInAdmin();

        $this->post(route('admin.users.store'), [
            'name' => $this->length256,
            'email' => 'henry@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])/*;
        $this->assertDatabaseHas('users', ['email' => 'henry@mail.com']);*/
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function creating_a_user_requires_a_email()
    {
        $this->signInAdmin();

        $this->post(route('admin.users.store'), [
            'name' => 'henry',
            'email' => null,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function creating_user_email_must_be_255_or_less()
    {
        $this->signInAdmin();

        $this->post(route('admin.users.store'), [
            'name' => 'henry',
            'email' => $this->length256,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function creating_user_email_must_be_correct_format()
    {
        $this->signInAdmin();

        $this->post(route('admin.users.store'), [
            'name' => 'henry',
            'email' => 'asshandle',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function creating_a_user_requires_a_password()
    {
        $this->signInAdmin();

        $this->post(route('admin.users.store'), [
            'name' => 'henry',
            'email' => 'henry@mail.com',
            'password' => null,
            'password_confirmation' => 'password',
        ])
            ->assertSessionHasErrors('password');
    }

    /** @test */
    public function creating_a_user_requires_the_passwords_match()
    {
        $this->signInAdmin();

        $this->post(route('admin.users.store'), [
            'name' => 'henry',
            'email' => 'henry@mail.com',
            'password' => 'assword',
            'password_confirmation' => 'password',
        ])
            ->assertSessionHasErrors('password');
    }

    /** @test */
    public function creating_user_password_must_be_255_or_less()
    {
        $this->signInAdmin();

        $this->post(route('admin.users.store'), [
            'name' => 'henry',
            'email' => 'henry@mail.com',
            'password' => $this->length256,
            'password_confirmation' => $this->length256,
        ])
            ->assertSessionHasErrors('password');
    }

    /** @test */
    public function edit_user_screen_can_be_rendered_by_signed_in_admin()
    {
        $this->signInAdmin();

        $user = User::factory()->create();

        $this->get(route('admin.users.edit', $user->id))
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_be_updated()
    {
        $this->signInAdmin();

        $user = User::factory()->create([
            'name' => 'asshandle'
        ]);
        $userChanged = [
            'name' => 'changed'
        ];

        $this->patch(route('admin.users.update', $user->id), $userChanged);

        $this->assertDatabaseHas('users', [
            'name' => $userChanged['name']
        ]);
    }

    /** @test */
    public function updating_a_user_requires_a_name()
    {
        $this->signInAdmin();

        $user = User::factory()->create();

        $userChanged = [
            'name' => null,
        ];

        $this->patch(route('admin.users.update', $user->id), $userChanged)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function updating_a_user_name_must_be_255_or_less()
    {
        $this->signInAdmin();

        $user = User::factory()->create();

        $userChanged = [
            'name' => $this->length256,
        ];

        $this->patch(route('admin.users.update', $user->id), $userChanged)
            ->assertSessionHasErrors('name');
    }


    /*public function updating_a_user_requires_a_email()
    {
        $user = User::factory()->create([
            'name' => 'asshandle',
            'email' => 'asshandle@mail.com',
        ]);

        $userChanged = [
            'name' => 'asshandle',
            'email' => ''
        ];

        $this->patch(route('admin.users.update', $user->id), $userChanged)
            ->assertSessionHasErrors('email');
    }*/


    /*public function updating_a_user_email_must_be_255_or_less()
    {
        $user = User::factory()->create([
            'name' => 'asshandle',
            'email' => 'asshandle@mail.com',
        ]);

        $userChanged = [
            'name' => 'asshandle',
            'email' => $this->length256
        ];

        $this->patch(route('admin.users.update', $user->id), $userChanged)
            ->assertSessionHasErrors('email');
    }*/

    /*public function updating_user_email_must_be_correct_format()
    {
        $user = User::factory()->create([
            'name' => 'asshandle',
            'email' => 'asshandle@mail.com',
        ]);

        $userChanged = [
            'name' => 'asshandle',
            'email' => 'asshandle'
        ];

        $this->patch(route('admin.users.update', $user->id), $userChanged)
            ->assertSessionHasErrors('email');
    }*/

    /** @test */
    public function user_can_be_deleted_by_signed_in_admin()
    {
        $this->signInAdmin();

        $user = User::factory()->create();

        $this->delete(route('admin.users.destroy', $user->id));

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}
