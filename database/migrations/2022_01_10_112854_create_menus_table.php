<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pid')->default(0)->comment('父级ID');
            $table->string('name', 50)->default('')->comment('唯一标识');
            $table->string('label', 50)->default('')->comment('显示名称');
            $table->string('type', 50)->default('')->comment('菜单类型');
            $table->string('url')->default('')->comment('页面地址');
            $table->string('icon', 50)->default('')->comment('图标');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
