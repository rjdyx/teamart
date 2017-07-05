<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->comment('商品id');
            $table->integer('user_id')->comment('用户id');
            $table->integer('grade')->default(100)->comment('满意度');
            $table->text('content')->comment('评论内容');
            $table->string('img',255)->nullable()->comment('评论图片');
            $table->string('thumb',255)->nullable()->comment('缩略图');
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
        Schema::dropIfExists('comment');
    }
}
