<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all();
        User::all()->each(function ($user) use ($roles) {
            if ($user->name !== 'henry') {
                $user->roles()->attach(
                    $roles->random(2)->pluck('id')
                );
            } else {
                $user->roles()->attach([
                    1, 2, 3
                ]);
            }
        });
    }
}
