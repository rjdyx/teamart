<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('site', function (Blueprint $table) {
            $table->increments('id');
            $table->string('province',100)->comment('省');
            $table->string('city',100)->comment('市');
            $table->string('area',255)->comment('区/县');
            $table->string('detail',255)->comment('详细地址');
            $table->string('user',50)->comment('负责人');
            $table->string('phone',50)->comment('站点电话');
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
        //
        Schema::dropIfExists('site');
    }
}
