<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTypesTable extends Migration
{
    /**
     * Run the migrations.
     *  message短信类型表
     * 0.申请，    1.公共    2.私信    3.要求    4.等等
     * @return void
     */
    public function up()
    {
        Schema::create('message_t', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
        Schema::create('message_types', function (Blueprint $table) {
            $table->increments('id');
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
        Schema::dropIfExists('message_t');
        Schema::dropIfExists('message_types');
    }
}
