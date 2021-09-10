<?php

use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class RbacSetupTables
 */
class CreateRbacTables extends Migration
{
    /**
     * @throws Exception
     */
    public function up()
    {
        $tableName = config('rbac.table');
        $foreignKey = config('rbac.foreignKey');

        DB::beginTransaction();

        // 菜单
        Schema::create($tableName['menus'], function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('pid')->default(0)->comment('父级菜单');
            $table->string('name')->comment('唯一标识');
            $table->string('title')->default('')->comment('菜单名称');
            $table->string('icon')->default('图标');
            $table->string('url')->default('图标');
            $table->string('controller')->comment('控制器')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        // 动作
        Schema::create($tableName['actions'], function (Blueprint $table) {
            $table->id('id');
            $table->string('label')->default('')->comment('菜单名称');
            $table->string('action')->default('')->comment('控制器')->unique();
            $table->morphs('able');
            $table->timestamps();
        });

        // 角色
        Schema::create($tableName['roles'], function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->comment('唯一标识');
            $table->string('title')->default('显示名称');
            $table->string('remark')->default('备注');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态');
            $table->softDeletes();
            $table->timestamps();
        });

        // 权限 每个菜单，每个动作都是一个权限节点
        Schema::create($tableName['permissions'], function (Blueprint $table) {
            $table->id('id');
            $table->string('label')->comment('权限名称');
            $table->morphs('able');
            $table->timestamps();
        });

        // 角色用户
        Schema::create($tableName['roleUser'], function (Blueprint $table) use ($tableName, $foreignKey) {
            $table->unsignedBigInteger($foreignKey['user']);
            $table->unsignedBigInteger($foreignKey['role']);

            $table->primary([$foreignKey['user'], $foreignKey['role']]);
        });

        // 角色权限
        Schema::create($tableName['permissionRole'], function (Blueprint $table) use ($tableName, $foreignKey) {
            $table->unsignedBigInteger($foreignKey['permission']);
            $table->unsignedBigInteger($foreignKey['role']);
            $table->primary([$foreignKey['permission'], $foreignKey['role']]);
        });

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableName = config('rbac.table');

        Schema::drop($tableName['permissionRole']);
        Schema::drop($tableName['permissions']);
        Schema::drop($tableName['roleUser']);
        Schema::drop($tableName['roles']);
    }
}
