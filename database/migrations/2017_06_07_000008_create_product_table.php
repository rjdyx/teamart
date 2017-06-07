<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->comment('商品分类id');
            $table->integer('user_id')->comment('用户id');
            $table->integer('brand_id')->comment('品牌id');
            $table->string('name',50)->comment('商品名称');
            $table->double('price_raw', 15, 2)->comment('原始价格')->nullable();
            $table->double('price', 15, 2)->comment('价格');
            $table->string('origin',255)->nullable()->comment('生产地址');
            $table->text('desc',255)->nullable()->comment('描述');
            $table->dateTime('date')->nullable()->comment('生产日期');
            $table->string('img',255)->nullable()->comment('二维码图片');
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
        Schema::dropIfExists('product');
    }
}
