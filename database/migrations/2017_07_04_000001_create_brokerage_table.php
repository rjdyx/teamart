<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brokerage', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('分销商id');
            $table->integer('amount')->comment('订单数量')->default(0);
            $table->double('count', 15, 2)->comment('总金额')->default(0);
            $table->date('date')->comment('结账日期');
            $table->double('scale', 4, 2)->comment('佣金比')->default(0.01);
            $table->double('price', 15, 2)->comment('实际结账金额')->default(0);
            $table->double('remain', 15, 2)->comment('未结清金额')->default(0);
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
        Schema::dropIfExists('brokerage');
    }
}
