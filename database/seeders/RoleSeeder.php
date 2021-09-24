<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

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
            ['id' => 1, 'name' => 'Administrator', 'title' => '超级管理员'],
            ['id' => 2, 'name' => 'Test', 'title' => '测试人员'],
        ];

        foreach ($roles as $item) {
            $role = new Role($item);
            $role->save();
        }
    }
}
