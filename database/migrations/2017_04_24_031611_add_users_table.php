<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->boolean('isLock')->default(false);//
            $table->string('avatar')->nullable();//
            $table->integer('default_address_id')->nullable();//
            $table->float('proportion')->default(0);//
            $table->tinyInteger('type')->default(App\User::TYPE_USER);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn(['isLock', 'avatar', 'default_address_id','proportion','type','deleted_at']);
        });
    }
}
