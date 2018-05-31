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
            $table->string('avatar')->default('/storage/upload/class/default.png')->comment('班级名字');
            $table->string('name')->comment('班级名字');
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
            $table->integer('user_id')->unsigned()->comment('用户id');
            $table->integer('class_id')->unsigned()->comment('班级id');
            $table->unsignedSmallInteger('is_join')->nullable()->comment('是否加入(加入为空，还未审核，表示有)');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        //班级类型中间表（多对多关系）
        Schema::create('class_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category')->comment('班级类型');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('class_t', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('class_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->softDeletes();
            $table->foreign('class_id')->references('id')->on('classes')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('class_type')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        //班级类型


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
        Schema::dropIfExists('class_t');

    }
}
