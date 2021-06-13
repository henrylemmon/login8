<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_have_roles()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->roles);
    }

    /** @test */
    public function user_can_be_assigned_a_role()
    {
        $user = User::factory()->create();

        $role = Role::Factory()->create([
            'name' => 'Admin'
        ]);

        $user->roles()->attach($role->id);

        $this->assertCount(1, $user->roles);
        $this->assertEquals('Admin', $user->roles->first()->name);
    }

    /** @test */
    public function user_can_be_assigned_multiple_roles()
    {
        $user = User::factory()->create();

        $role1 = Role::Factory()->create([
            'name' => 'Admin'
        ]);
        $role2 = Role::Factory()->create([
            'name' => 'Author'
        ]);
        $role3 = Role::Factory()->create([
            'name' => 'User'
        ]);

        $user->roles()->attach([
            $role1->id,
            $role2->id,
            $role3->id,
        ]);

        $this->assertCount(3, $user->roles);
        $this->assertEquals($role1->name, $user->roles[0]->name);
        $this->assertEquals($role2->name, $user->roles[1]->name);
        $this->assertEquals($role3->name, $user->roles[2]->name);
    }

    /** @test */
    public function user_can_check_if_it_has_or_does_not_have_a_role()
    {
        $user = User::factory()->create();

        $role = Role::factory()->create([
            'name' => 'certainRole',
        ]);

        $user->roles()->attach($role->id);

        $this->assertTrue($user->hasAnyRole($role->name));
        $this->assertNotTrue($user->hasAnyRole('bullshit'));
    }

    /** @test */
    public function user_can_check_if_it_has_any_of_the_given_roles()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $role = Role::factory()->create([
            'name' => 'certainRole',
        ]);

        $otherRole = Role::factory()->create([
            'name' => 'otherRole',
        ]);

        $user->roles()->attach($role->id);

        $roles = array_merge([$role->name], [$otherRole->name]);

        $this->assertTrue($user->hasAnyRoles($roles));
        $this->assertNotTrue($otherUser->hasAnyRoles($roles));
    }
}
