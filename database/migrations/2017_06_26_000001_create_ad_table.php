<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',50)->comment('标题');
            $table->string('desc',255)->nullable()->comment('描述');
            $table->string('img',255)->nullable()->comment('图片');
            $table->string('thumb',255)->nullable()->comment('缩略图');
            $table->string('url',255)->nullable()->comment('链接');
            $table->tinyInteger('state')->defualt(1)->comment('开启状态（0为关闭）');
            $table->string('position')->defualt('index')->comment('广告展示位置');
            $table->softDeletes(); 
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
        Schema::dropIfExists('ad');
    }
}
