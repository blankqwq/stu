<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //班级表
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('班级名字');
            $table->unsignedInteger('type')->comment('班级类型');
            $table->unsignedBigInteger('user_id')->comment('头目or创建者id');
            $table->unsignedInteger('number')->comment('数量');
            $table->string('password')->nullable()->comment('加入班级密码');
            $table->unsignedSmallInteger('verification')->comment('是否需要验证');
            $table->unsignedInteger('user_allow')->nullable()->comment('审核人');
            $table->timestamps();
            $table->softDeletes();
        });

        //班级和用户的直接关联
        //满足多对多的关系
        Schema::create('user_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->comment('用户id');
            $table->unsignedBigInteger('class_id')->comment('班级id');
            $table->unsignedSmallInteger('is_join')->nullable()->comment('是否加入(加入为空，还未审核，表示有)');
            $table->timestamps();
        });

        //班级类型表
        Schema::create('class_type', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('class_id')->comment('班级id');
            $table->string('category')->comment('班级类型');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
        Schema::dropIfExists('user_classes');
        Schema::dropIfExists('class_type');
    }
}
