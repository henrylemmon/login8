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
    public function create_user_screen_can_be_rendered()
    {
        $this->get(route('admin.users.create'))
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_be_created()
    {
        $user = User::factory()->raw();

        $this->post(route('admin.users.store'), $user);

        $this->assertDatabaseHas('users', [
           'email' => $user['email']
        ]);
    }

    /** @test */
    public function creating_a_user_requires_a_name()
    {
        $user = User::factory()->raw(['name' => '']);

        $this->post(route('admin.users.store'), $user)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function creating_user_name_must_be_255_or_less()
    {
        $user = User::factory()->raw([
            'name' => $this->length256
        ]);

        $this->post(route('admin.users.store'), $user)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function creating_a_user_requires_a_email()
    {
        $user = User::factory()->raw(['email' => '']);

        $this->post(route('admin.users.store'), $user)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function creating_user_email_must_be_255_or_less()
    {
        $user = User::factory()->raw([
            'email' => $this->length256
        ]);

        $this->post(route('admin.users.store'), $user)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function creating_user_email_must_be_correct_format()
    {
        $user = User::factory()->raw([
            'email' => 'asshandle'
        ]);

        $this->post(route('admin.users.store'), $user)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function creating_a_user_requires_a_password()
    {
        $user = User::factory()->raw(['password' => '']);

        $this->post(route('admin.users.store'), $user)
            ->assertSessionHasErrors('password');
    }

    /** @test */
    public function creating_user_password_must_be_255_or_less()
    {
        $user = User::factory()->raw([
            'password' => $this->length256
        ]);

        $this->post(route('admin.users.store'), $user)
            ->assertSessionHasErrors('password');
    }

    /** @test */
    public function edit_user_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->get(route('admin.users.edit', $user->id))
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_be_updated()
    {
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
        $user = User::factory()->create([
            'name' => 'asshandle',
            'email' => 'asshandle@mail.com',
        ]);

        $userChanged = [
            'name' => '',
            'email' => 'asshandle@mail.com'
        ];

        $this->patch(route('admin.users.update', $user->id), $userChanged)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function updating_a_user_name_must_be_255_or_less()
    {
        $user = User::factory()->create([
            'name' => 'asshandle',
            'email' => 'asshandle@mail.com',
        ]);

        $userChanged = [
            'name' => $this->length256,
            'email' => 'asshandle@mail.com'
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
    public function user_can_be_deleted()
    {
        $user = User::factory()->create();

        $this->delete(route('admin.users.destroy', $user->id));

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}
