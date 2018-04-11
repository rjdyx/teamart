<?php

use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('product_categories')->insert([
        	'id'=>10,
        	'name'=>'a',
        	'parent_id'=>null,
        ]);
    }
}
