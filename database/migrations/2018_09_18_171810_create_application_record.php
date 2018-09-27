<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_record', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_user_id')->comment('申请用户  关联用户id');
            $table->integer('target_users_id')->comment('目标用户  关联用户id');
            $table->integer('type')->comment('申请类型:  1:一级申请(一级用户发展自己的二级经销商) 0:反向申请(普通用户向一级经销商申请成为其二级经销商)');
            $table->text('message')->comment('消息:申请时发送给对方确认的信息');
            $table->double('scale',4,2)->comment('提成(佣金比)');
            $table->date('date')->comment('申请时间  记录申请时的时间');
            $table->integer('status')->default(2)->comment('申请状态 0:申请被拒绝 1:申请通过 2:申请中(默认状态) 3：失效状态(一级经销商的二级经销商数量已经超过规定值后再进行同意时的状态)');
            $table->softDeletes();//软删除
            $table->timestamps();//记录创建时间和修改时间
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_record');
    }
}
