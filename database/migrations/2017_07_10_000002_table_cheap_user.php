<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableCheapUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cheap_user', function (Blueprint $table) {
            $table->tinyInteger('state',0)->default(0)->comment('领取状态，1为领取');
        });
    }

}
