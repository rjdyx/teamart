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
            $table->integer('spec_id')->comment('规格id');
            $table->integer('group_id')->nullable()->comment('商品组id');
            $table->string('name',50)->comment('商品名称');
            $table->double('price_raw', 15, 2)->comment('原始价格')->nullable();
            $table->double('price', 15, 2)->comment('价格');
            $table->double('delivery_price', 15, 2)->default(0)->comment('邮费');
            $table->integer('stock')->default(0)->comment('库存');
            $table->integer('low_stock')->default(0)->comment('低库存');
            $table->string('effect',255)->nullable()->comment('作用');
            $table->string('origin',255)->nullable()->comment('生产地址');
            $table->text('desc',255)->nullable()->comment('描述');
            $table->date('date')->nullable()->comment('生产日期');
            $table->string('img',255)->nullable()->comment('图片');
            $table->string('thumb',255)->nullable()->comment('缩略图');
            $table->tinyInteger('grade')->default(0)->comment('积分使用 默认为0（1可以使用）');
            $table->tinyInteger('state')->default(1)->comment('商品状态 默认为1（0为缺货）');
            $table->integer('sell_amount')->default(0)->comment('销售总量');
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
