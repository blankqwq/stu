<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tiku_id')->unsigned()->comment('题库id');
            $table->unsignedInteger('number')->comment('题目数量');
            $table->string('title')->comment('任务标题');
            $table->text('content')->comment('任务内容');
            $table->unsignedSmallInteger('times')->comment('答题次数');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('tiku_id')->references('id')->on('questions')
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
        Schema::dropIfExists('question_tasks');
    }
}
