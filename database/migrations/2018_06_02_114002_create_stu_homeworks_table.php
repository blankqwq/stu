<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStuHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stu_homeworks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('交作业人id');
            $table->integer('homework_id')->unsigned()->comment('作业id');
//            多对一
            $table->text('content')->comment('内容');
            $table->string('attachment')->comment('文件url');
            $table->unsignedInteger('fraction')->nullable()->comment('分数');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('homework_id')->references('id')->on('homeworks')
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
        Schema::dropIfExists('stu_homeworks');
    }
}
