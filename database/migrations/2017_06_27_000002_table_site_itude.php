<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSiteItude extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site', function (Blueprint $table) {
            $table->double('longitude')->comment('经度');
            $table->double('latitude')->comment('纬度');
            $table->string('name',100)->comment('站点名称');
            $table->dropColumn('city');
            $table->dropColumn('area');
            $table->dropColumn('province');
            $table->dropColumn('detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site', function (Blueprint $table) {
            //
        });
    }
}
