<?php

return [

    // 模型命名空间
    'model' => [
        'role' => 'App\Models\Role',
        'user' => 'App\Models\User',
        'role_user' => 'App\Models\RoleUser',
        'permission' => 'App\Models\Permission',
    ],

    // 表名称
    'table' => [
        'users' => 'users',
        'roles' => 'roles',
        'role_user' => 'role_user',
        'permissions' => 'permissions',
        'permission_role' => 'permission_role',
    ],

    // 外键
    'foreignKey' => [
        'role' => 'role_id',
        'user' => 'user_id',
        'permission' => 'permission_id',
    ],

    // 模型授权
    'permissionModel' => [
//        \App\Category::class => 'categories',
    ],

    // 定界符
    'delimiter' => '|',

    // 控制器action label 替换
    'resourceAbilityMapLabel' => [
        'index' => '列表',
        'show' => '详情',
        'create' => '新增',
        'store' => '新增',
        'edit' => '更新',
        'update' => '更新',
        'destroy' => '删除',
        'restore' => '恢复',
    ],

    // 控制器action name 替换
    'resourceAbilityMap' => [
        'index' => 'list',
        'show' => 'view',
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'destroy' => 'delete',
    ],

    // 需要生成权限节点的控制器
    'needGeneratePermission' => [
//        \App\Http\Controllers\RoleController::class => '角色管理',
    ],

    // 指定路径前缀
    'path' => [
        'backend/users',
        'backend/roles',
        'backend/configs',
        'backend/permissions',
    ],

    // 排除路径前缀
    'except_path' => [
//        'backend/permissions/auto',
    ]
];
