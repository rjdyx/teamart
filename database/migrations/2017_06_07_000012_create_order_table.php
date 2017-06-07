<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->nullable()->comment('分销商id');
            $table->integer('address_id')->comment('地址id');
            $table->integer('user_id')->comment('用户id');
            $table->string('serial',100)->comment('订单号');
            $table->double('price', 10, 2)->default(0.00)->comment('价格');
            $table->string('type',50)->comment('订单类型(order订单、cart购物车、collect收藏)');
            $table->string('state',50)->default('pending')->comment('订单状态(pending未支付、paid已支付、close关闭、cancelled取消、recede退货)');
            $table->dateTime('date')->comment('下单日期');
            $table->text('memo')->nullable()->comment('备注');
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
        Schema::dropIfExists('order');
    }
}
