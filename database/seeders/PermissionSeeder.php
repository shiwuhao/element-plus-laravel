<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'pid' => 0, 'type' => 'menu', 'title' => '系统管理', 'name' => 'SystemMange', 'icon' => 'el-icon-menu', 'method' => 'get', 'url' => '/system'],
            ['id' => 2, 'pid' => 1, 'type' => 'menu', 'title' => '用户管理', 'name' => 'UserManage', 'icon' => 'el-icon-user-solid', 'method' => 'get', 'url' => '/system/users'],
            ['id' => 3, 'pid' => 1, 'type' => 'menu', 'title' => '角色管理', 'name' => 'RoleManage', 'icon' => 'fa fa-sitemap', 'method' => 'get', 'url' => '/system/roles'],
            ['id' => 4, 'pid' => 1, 'type' => 'menu', 'title' => '权限管理', 'name' => 'PermissionManage', 'icon' => 'fa fa-linode', 'method' => 'get', 'url' => '/system/permissions'],
            ['id' => 5, 'pid' => 1, 'type' => 'menu', 'title' => '配置管理', 'name' => 'ConfigManage', 'icon' => 'el-icon-setting', 'method' => 'get', 'url' => '/system/configs'],
        ];

        foreach ($data as $item) {
            $permission = new Permission($item);
            $permission->save();
        }


    }
}
