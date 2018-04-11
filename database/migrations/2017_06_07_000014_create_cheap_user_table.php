<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheapUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheap_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cheap_id')->comment('优惠券id');
            $table->integer('user_id')->comment('用户id');
            $table->tinyInteger('state',0)->default(0)->comment('领取状态，1为领取');
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
        Schema::dropIfExists('cheap_user');
    }
}
