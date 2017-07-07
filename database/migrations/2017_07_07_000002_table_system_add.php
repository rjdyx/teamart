<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSystemAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('system', function (Blueprint $table) {
            $table->string('delivery_key',255)->nullable()->comment('物流key');
            $table->string('delivery_id',50)->nullable()->comment('物流商户ID');
        });

        Schema::table('order', function (Blueprint $table) {
            $table->string('coding',50)->nullable()->comment('物流公司编号');
        });
    }

}
