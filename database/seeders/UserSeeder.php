<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(30)->create();

        $adminRole = Role::find(1);
        $testRole = Role::find(2);

        $testRole->permissions()->sync([1, 2, 3, 4]);

        $user = User::find(1);
        $user->username = 'shiwuhao';
        $user->password = bcrypt('111111');
        $user->save();
        $user->roles()->sync([$adminRole->id]);

        $user = User::find(2);
        $user->username = 'Test';
        $user->password = bcrypt('111111');
        $user->save();
        $user->roles()->sync([$testRole->id]);
    }
}
