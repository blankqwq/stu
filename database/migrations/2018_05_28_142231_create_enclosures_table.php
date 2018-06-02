<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnclosuresTable extends Migration
{
    /**
     * Run the migrations.
     *消息附件
     * @return void
     */
    public function up()
    {
        Schema::create('enclosures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->comment('附件地址');
            $table->string('name');
            $table->string('size');
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
        Schema::dropIfExists('enclosures');
    }
}
