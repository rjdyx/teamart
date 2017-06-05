<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $user = User::firstOrNew(['email' => 'admin@qq.com']);
	    $user->name = 'admin';
	    $user->password = bcrypt('123456');
	    $user->type = User::TYPE_ADMIN;
	    $user->save();
    }
}
