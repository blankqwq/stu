<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *消息回复,一对多
     * @return void
     */
    public function up()
    {
        Schema::create('message_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id')->unsigned()->comment('回复的message_id');
            $table->integer('user_id')->unsigned()->comment('回复人');
            $table->string('content')->comment('回复内容');
            $table->unsignedInteger('pid')->default(0)->comment('父级别id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('message_id')->references('id')->on('messages')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('message_replies');
    }
}
