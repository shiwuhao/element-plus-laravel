<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->default('')->comment('配置标识')->unique();
            $table->string('title', 50)->default('')->comment('配置名称');
            $table->string('group', 50)->default('')->comment('分组');
            $table->string('type', 50)->default('')->comment('类型');
            $table->string('component', 50)->default('')->comment('渲染组件');
            $table->unsignedInteger('sort')->default(0)->comment('排序')->index();
            $table->text('value')->nullable()->comment('配置值');
            $table->text('extra')->nullable()->comment('扩展');
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
        Schema::dropIfExists('configs');
    }
}
