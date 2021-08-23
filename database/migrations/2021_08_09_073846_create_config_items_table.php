<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_items', function (Blueprint $table) {
            $table->id()->startingValue(10000);
            $table->unsignedBigInteger('config_id')->default(0)->comment('配置ID')->index();
            $table->unsignedBigInteger('pid')->default(0);
            $table->string('title', 50)->default('')->comment('名称');
            $table->string('code', 50)->default('')->comment('代码');
            $table->unsignedInteger('sort')->default(0)->comment('排序')->index();
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
        Schema::dropIfExists('config_items');
    }
}
