<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->nullable()->comment('网站名称');
            $table->string('email',50)->nullable()->comment('意见邮箱');
            $table->string('phone',50)->nullable()->comment('热线电话');
            $table->string('logo',255)->nullable()->comment('网站logo');
            $table->string('record',255)->nullable()->comment('网站备案号');
            $table->text('keywords')->nullable()->comment('关键字');
            $table->tinyInteger('verify_state')->default(1)->comment('验证码开关(0关1开)');
            $table->tinyInteger('gender')->default(0)->comment('性别(0男、1女)');
            $table->integer('grade')->default(0)->comment('积分');
            $table->double('free', 15, 2)->comment('免邮金额')->nullable();
            $table->double('full_cut', 15, 2)->comment('满减')->nullable();
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
        Schema::dropIfExists('system');
    }
}
