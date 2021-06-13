<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'author',
            'user'
        ];

        foreach($roles as $role) {
            Role::factory()->create([
                'name' => $role
            ]);
        }

        //Role::factory()->times(10)->create();

        /*DB::table('roles')->insert([
            'name' => 'Admin'
        ]);

        DB::table('roles')->insert([
            'name' => 'Author'
        ]);

        DB::table('roles')->insert([
            'name' => 'User'
        ]);*/
    }
}
