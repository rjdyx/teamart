<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSpec extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spec', function (Blueprint $table) {
            $table->double('price', 15, 2)->default(0)->comment('价格');
            $table->integer('product_id')->comment('商品id');
            $table->tinyInteger('state')->default(0)->comment('默认规格,1默认');
        });
    } 
}
