<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_img', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->comment('商品组id');
            $table->string('img',255)->comment('图片');
            $table->string('thumb',255)->comment('图片小图');
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
        Schema::dropIfExists('product_img');
    }
}
