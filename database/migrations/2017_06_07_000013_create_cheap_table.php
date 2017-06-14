<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheap', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->comment('活动名称');
            $table->double('full', 10, 2)->default(0.00)->comment('满金额');
            $table->double('cut', 10, 2)->default(0.00)->comment('减金额');
            $table->integer('amount')->default(0)->comment('数量');
            $table->dateTime('indate')->comment('有效期');
            $table->tinyInteger('state')->default(1)->comment('默认1 (0为关闭)');
            $table->text('desc',255)->nullable()->comment('活动描述');
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
        Schema::dropIfExists('cheap');
    }
}
