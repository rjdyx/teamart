<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->comment('文章分类id');
            $table->string('name',50)->comment('文章名称');
            $table->text('content')->nullable()->comment('文章内容');
            $table->string('img',255)->nullable()->comment('图片');
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
        Schema::dropIfExists('article');
    }
}
