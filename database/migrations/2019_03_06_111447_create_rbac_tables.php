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

        // 权限
        Schema::create($tableName['permissions'], function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('pid')->default(0)->index();
            $table->string('type')->comment('类型 menu:菜单 action:动作')->index();
            $table->string('name')->comment('权限名称');
            $table->string('title')->comment('权限名称');
            $table->string('icon', 50)->default('')->comment('图标');
            $table->string('method', 50)->default('get')->comment('请求方式');
            $table->string('url', 100)->default('')->comment('url');
            $table->unsignedBigInteger('sort')->default(0)->comment('排序');
            $table->timestamps();

            $table->unique('name');
            $table->unique(['method', 'url']);
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
