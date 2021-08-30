<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->default(0)->comment('用户ID');
            $table->unsignedInteger('size')->default(0)->comment('文件大小');
            $table->string('url', 255)->default('')->comment('地址');
            $table->string('name', 255)->default('')->comment('原始文件名');
            $table->char('ext', 5)->default('')->comment('文件后缀');
            $table->char('mime', 40)->default('')->comment('文件mime类型');
            $table->char('md5', 32)->default('')->comment('文件md5编码');
            $table->char('sha1', 40)->default('')->comment('文件sha1编码');
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
        Schema::dropIfExists('files');
    }
}
