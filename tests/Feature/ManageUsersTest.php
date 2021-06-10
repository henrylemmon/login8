<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageUsersTest extends TestCase
{
    use RefreshDatabase;

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
