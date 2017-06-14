<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->comment('�����');
            $table->double('price', 10, 2)->default(0.00)->comment('�Żݼ۸�');
            $table->dateTime('date_start')->comment('��ʼʱ��');
            $table->dateTime('date_end')->comment('����ʱ��');
            $table->string('desc',255)->nullable()->comment('�����');
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
        Schema::dropIfExists('activity');
    }
}
