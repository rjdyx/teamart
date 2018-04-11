<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parter_id')->nullable()->comment('分销角色id');
            $table->string('name',30)->comment('用户名');
            $table->string('email',50)->comment('邮箱')->nullable();
            $table->string('password',255)->comment('密码');
            $table->string('realname',50)->comment('姓名')->nullable();
            $table->string('phone',50)->nullable()->comment('手机号码');
            $table->string('birth_date',50)->nullable()->comment('出生日期');
            $table->string('img',255)->nullable()->comment('头像');
            $table->string('thumb',255)->nullable()->comment('头像缩略图');
            $table->tinyInteger('type')->default(2)->comment('用户类型');
            $table->tinyInteger('gender')->default(0)->comment('性别(0男、1女)');
            $table->integer('grade')->default(0)->comment('积分');
            $table->double('sell_count', 15, 2)->default(0.00)->nullable()->comment('代理商销售总额');
            $table->rememberToken();
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
        Schema::dropIfExists('user');
    }
}
