<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function role_can_belong_to_many_users()
    {
        $role = Role::factory()->create();

        $this->assertInstanceOf(Collection::class, $role->users);
    }
}
