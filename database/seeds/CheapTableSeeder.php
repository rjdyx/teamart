<?php

use Illuminate\Database\Seeder;

class CheapTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory('App\Cheap', 50)->create();
    }
}
