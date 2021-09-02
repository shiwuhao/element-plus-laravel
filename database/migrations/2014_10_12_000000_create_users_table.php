<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('nickname', 50);
            $table->string('password');
            $table->string('avatar')->default('')->comment('头像');
            $table->unsignedTinyInteger('gender')->default(0)->comment('性别');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态');
            $table->string('source', 50)->default('')->comment('来源');
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
        Schema::dropIfExists('users');
    }
}
