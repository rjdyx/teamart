<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory('App\User', 50)->create();
        
        //管理员
        $check = User::where('name','admin')->first();
        if (empty($check)) {
            $user = new User;
            $user->name = 'admin';
            $user->email = 'admin@qq.com';
            $user->password = bcrypt(000000);
            $user->type = 0;
            $user->save();
        }

        //经销商
        $check = User::where('name','sell')->first();
        if (empty($check)) {
            $user = new User;
            $user->name = 'sell';
            $user->email = 'sell@qq.com';
            $user->password = bcrypt(000000);
            $user->type = 1;
            $user->save();
        }

        //会员
        $check = User::where('name','user')->first();
        if (empty($check)) {
            $user = new User;
            $user->name = 'user';
            $user->email = 'user@qq.com';
            $user->password = bcrypt(000000);
            $user->type = 2;
            $user->save();
        }
    }
}
