<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->comment('活动名称');
            $table->double('price', 10, 2)->default(0.00)->comment('优惠价格');
            $table->dateTime('date_start')->comment('开始时间');
            $table->dateTime('date_end')->comment('结束时间');
            $table->string('desc',255)->nullable()->comment('活动描述');
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
        Schema::dropIfExists('activity');
    }
}
