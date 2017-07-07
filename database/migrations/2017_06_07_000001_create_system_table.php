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
            $table->text('slider',255)->nullable()->comment('轮播图');
            $table->string('record',255)->nullable()->comment('网站备案号');
            $table->text('keywords')->nullable()->comment('关键字');
            $table->tinyInteger('verify_state')->default(1)->comment('验证码开关(0关1开)');
            $table->double('free', 15, 2)->comment('免邮金额')->nullable();
            $table->string('qq',255)->nullable()->comment('QQ');
            $table->string('delivery_key',255)->nullable()->comment('物流key');
            $table->string('delivery_id',50)->nullable()->comment('物流商户ID');
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
