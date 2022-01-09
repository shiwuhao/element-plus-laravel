<?php

namespace Database\Seeders;

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
            ['id' => 1, 'pid' => 0, 'type' => 'menu', 'title' => 'Dashboard', 'name' => 'Dashboard', 'icon' => 'fa fa-home', 'method' => 'get', 'url' => '/dashboard'],
            ['id' => 2, 'pid' => 1, 'type' => 'menu', 'title' => '工作台', 'name' => 'workplace', 'icon' => 'fa fa-dashboard', 'method' => 'get', 'url' => '/dashboard/workplace'],
            ['id' => 3, 'pid' => 1, 'type' => 'menu', 'title' => '监控页', 'name' => 'el-icon-monitor', 'icon' => 'el-icon-monitor', 'method' => 'get', 'url' => '/dashboard/monitor'],
            ['id' => 4, 'pid' => 1, 'type' => 'menu', 'title' => '分析页', 'name' => 'analysis', 'icon' => 'el-icon-data-analysis', 'method' => 'get', 'url' => '/dashboard/analysis'],
            ['id' => 5, 'pid' => 0, 'type' => 'menu', 'title' => '系统管理', 'name' => 'SystemMange', 'icon' => 'el-icon-menu', 'method' => 'get', 'url' => '/system'],
            ['id' => 6, 'pid' => 5, 'type' => 'menu', 'title' => '用户管理', 'name' => 'UserManage', 'icon' => 'el-icon-user-solid', 'method' => 'get', 'url' => '/system/users'],
            ['id' => 7, 'pid' => 5, 'type' => 'menu', 'title' => '角色管理', 'name' => 'RoleManage', 'icon' => 'fa fa-sitemap', 'method' => 'get', 'url' => '/system/roles'],
            ['id' => 8, 'pid' => 5, 'type' => 'menu', 'title' => '权限管理', 'name' => 'PermissionManage', 'icon' => 'fa fa-linode', 'method' => 'get', 'url' => '/system/menus'],
            ['id' => 9, 'pid' => 5, 'type' => 'menu', 'title' => '配置管理', 'name' => 'ConfigManage', 'icon' => 'el-icon-setting', 'method' => 'get', 'url' => '/system/configs'],
        ];

        foreach ($data as $item) {
//            $permission = new Permission($item);
//            $permission->save();
        }


    }
}
