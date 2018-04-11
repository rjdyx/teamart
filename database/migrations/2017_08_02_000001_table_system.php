<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('system', function (Blueprint $table) {
            $table->string('wx_appid',32)->nullable()->comment('微信公众号appid');
            $table->string('wx_appsecret',32)->nullable()->comment('公众号密匙key');
            $table->string('wx_mchid',32)->nullable()->comment('商户号');
            $table->string('wx_key',32)->nullable()->comment('商户密匙key');
            $table->string('wx_body',128)->nullable()->comment('支付描述');
        });
    }

}
