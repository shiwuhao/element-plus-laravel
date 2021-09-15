<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(30)->create();
        $user = User::find(1);
        $user->username = 'shiwuhao';
        $user->password = bcrypt('111111');
        $user->save();
    }
}
