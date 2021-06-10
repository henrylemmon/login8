<?php

namespace Tests\Feature;

use Illuminate\Support\Arr;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageUsersTest extends TestCase
{
    use RefreshDatabase;

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
    public function user_can_be_updated()
    {
        $user = User::factory()->create([
            'email' => 'asshandle@mail.com'
        ]);
        $userChanged = User::factory()->raw([
            'email' => 'changed@mail.com'
        ]);

        $this->patch(route('admin.users.update', $user->id), $userChanged);

        $this->assertDatabaseHas('users', [
            'email' => $userChanged['email']
        ]);
    }

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
