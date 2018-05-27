<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type_id')->comment('类型id');
            $table->string('title')->comment('消息标题');
            $table->text('content')->comment('消息内容');
            $table->unsignedInteger('user_id')->comment('发送人id');
            $table->unsignedInteger('messagetable_id')->comment('关联的模型id');
            $table->string('messagetable_type')->comment('关联模型的名字');
            $table->timestamps();
            $table->softDeletes()->comment('软删除');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
