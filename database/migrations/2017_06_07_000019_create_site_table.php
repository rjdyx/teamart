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
            $table->string('name',100)->comment('站点名称');
            $table->double('longitude')->comment('经度');
            $table->double('latitude')->comment('纬度');
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
