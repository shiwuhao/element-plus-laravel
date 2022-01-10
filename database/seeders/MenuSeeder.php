<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 5, 'pid' => 0, 'type' => 'menu', 'label' => '系统', 'name' => 'SystemMange', 'icon' => 'el-windows', 'url' => '/system'],
            ['id' => 6, 'pid' => 5, 'type' => 'menu', 'label' => '用户管理', 'name' => 'UserManage', 'icon' => 'el-icon-user-solid', 'url' => '/system/users'],
            ['id' => 7, 'pid' => 5, 'type' => 'menu', 'label' => '角色管理', 'name' => 'RoleManage', 'icon' => 'fa fa-sitemap', 'url' => '/system/roles'],
            ['id' => 8, 'pid' => 5, 'type' => 'menu', 'label' => '权限管理', 'name' => 'PermissionManage', 'icon' => 'fa fa-linode', 'url' => '/system/menus'],
            ['id' => 9, 'pid' => 5, 'type' => 'menu', 'label' => '配置管理', 'name' => 'ConfigManage', 'icon' => 'el-icon-setting', 'url' => '/system/configs'],
        ];

        foreach ($data as $item) {
            $menu = new Menu($item);
            $menu->save();
        }


    }
}
