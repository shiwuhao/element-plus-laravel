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
            ['id' => 1, 'pid' => 0, 'type' => 'menu', 'label' => '首页', 'name' => 'Dashboard', 'icon' => 'fa fa-home', 'url' => '/dashboard'],
            ['id' => 2, 'pid' => 1, 'type' => 'menu', 'label' => '工作台', 'name' => 'workplace', 'icon' => 'fa fa-dashboard', 'url' => '/dashboard/workplace'],
            ['id' => 3, 'pid' => 1, 'type' => 'menu', 'label' => '监控页', 'name' => 'el-icon-monitor', 'icon' => 'el-icon-monitor', 'url' => '/dashboard/monitor'],
            ['id' => 4, 'pid' => 1, 'type' => 'menu', 'label' => '分析页', 'name' => 'analysis', 'icon' => 'el-icon-data-analysis', 'url' => '/dashboard/analysis'],
            ['id' => 5, 'pid' => 0, 'type' => 'menu', 'label' => '系统', 'name' => 'SystemMange', 'icon' => 'el-icon-menu', 'url' => '/system'],
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
