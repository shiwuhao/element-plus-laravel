<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PersonalAccessTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $user->tokens()->create([
            'name' => 'backend',
            'token' => '11c40995978e82e59b1d76ec1a8e8bda4f8508f124093ddee88c96f75f212a9c',
            'abilities' => ['*']
        ]);
    }
}
