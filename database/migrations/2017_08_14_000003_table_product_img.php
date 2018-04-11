<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableProductImg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_img', function (Blueprint $table) {
            $table->dropColumn('group_id');
            $table->integer('product_id')->comment('商品id');
        });
    } 
}
