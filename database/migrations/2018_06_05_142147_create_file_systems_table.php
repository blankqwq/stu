<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('filetable_id')->comment('绑定的id');
            $table->integer('filetable_type')->comment('绑定的表');
            $table->string('name')->comment('文件夹名');
            $table->string('url')->nullable()->comment('文件所在url');
            $table->string('file_name')->nullable()->comment('文件名');
            $table->string('file_size')->nullable()->comment('文件大小');
            $table->integer('file_type')->default(0)->comment('文件类型,0为文件夹');
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
        Schema::dropIfExists('file_systems');
    }
}
