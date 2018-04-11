<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('group_id');
            $table->dropColumn('spec_id');
            $table->dropColumn('price');
            $table->dropColumn('price_raw');
            $table->text('details')->nullable()->comment('商品图文详细描述');
        });
        Schema::dropIfExists('product_group');
    } 
}
