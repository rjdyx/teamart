<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->string('name',50)->comment('收货人');
            $table->string('province',50)->comment('省');
            $table->string('city',50)->comment('市');
            $table->string('area',50)->comment('区/县');
            $table->string('phone',50)->comment('联系电话');
            $table->string('detail',255)->comment('详细地址');
            $table->integer('code')->nullable()->comment('邮编');
            $table->tinyInteger('state')->default(0)->comment('默认地址状态(1为默认地址)');
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
        Schema::dropIfExists('address');
    }
}
