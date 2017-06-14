<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->string('operate',50)->comment('操作行为(新增、编辑、删除)');
            $table->string('table',50)->comment('操作表');
            $table->string('ip',50)->nullable()->comment('ip地址');
            // $table->softDeletes(); 不用软删除
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
        Schema::dropIfExists('log');
    }
}
