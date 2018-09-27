<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->integer('upperparter_id')->nullable()->default(0)->comment('默认为0（代表为一级分销商）其它为分销商的ID');
            $table->string('scale',5)->default(0.00)->nullable()->comment('按销售额百分比或设置固定佣金');
            $table->integer('maxparternumber')->default(10)->comment('最多二级经销商个数，默认为10位');
        });
    }

    public function down(){
        Schema::table('user', function ($table) {
            $table->dropColumn('upperparter_id');
            $table->dropColumn('scale');
            $table->dropColumn('maxparternumber');
        });
    }

}
