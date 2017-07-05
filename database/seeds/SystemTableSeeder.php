<?php

use Illuminate\Database\Seeder;

class SystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system')->insert([
            'name' => '逸静',
            'email' => 'admin@163.com',
            'phone' => '13266668888',
            'keywords' => '分销,茶叶,水果,站点',
            'verify_state' => 1,
            'free' => 100
        ]); 
    }
}
