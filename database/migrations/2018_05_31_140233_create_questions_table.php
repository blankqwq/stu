<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiku', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('题库名');
            $table->unsignedInteger('number')->comment('题库量');
            $table->integer('user_id')->unsigned()->comment('关联创建人的id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('question_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('类型ming');
            $table->integer('user_id')->unsigned()->comment('关联创建人的id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');


        });
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tiku_id')->unsigned()->comment('关联的题库id');
            $table->integer('type_id')->unsigned()->comment('类型');
            $table->string('question')->comment('问题');;
            $table->string('optiona')->nullable()->comment('选项');;
            $table->string('optionb')->nullable();
            $table->string('optionc')->nullable();
            $table->string('optiond')->nullable();
            $table->string('answer')->comment('答案');
            $table->softDeletes();

            $table->foreign('tiku_id')->references('id')->on('tiku')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('question_type')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiku');
        Schema::dropIfExists('question_type');
        Schema::dropIfExists('questions');
    }
}
