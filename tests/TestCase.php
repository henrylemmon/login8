<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: User::factory()->create();
        $this->actingAs($user);
        return $this;
    }

    protected function signInAdmin($user = null)
    {
        $user = $user ?: User::factory()->create();
        $adminRole = Role::factory()->create([
            'name' => 'admin'
        ]);
        $user->roles()->attach($adminRole->id);
        $this->actingAs($user);
        return $this;
    }
}
