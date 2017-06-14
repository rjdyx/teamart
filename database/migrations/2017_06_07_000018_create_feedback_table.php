<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->text('content')->comment('反馈内容');
            $table->string('contact')->nullable()->comment('联系方式(手机/邮箱/qq)');
            $table->text('img')->nullable()->comment('反馈图片');
            $table->dateTime('date')->comment('反馈时间');
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
        //
        Schema::dropIfExists('feedback');
    }
}
