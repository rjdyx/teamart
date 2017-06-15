<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// 分销
class CreateParterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parter', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30)->comment('分销名称');
            $table->double('scale', 5, 2)->comment('分销比列')->nullable();
            $table->string('desc',50)->comment('描述')->nullable();
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
        Schema::dropIfExists('parter');
    }
}
