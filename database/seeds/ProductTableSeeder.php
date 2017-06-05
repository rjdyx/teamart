<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if(App\ProductCategory::find(100)==null){
        	DB::table('product_categories')->insert([
	            'id' => 100,
	            'name' => 'haha',
	        ]);
        }
        
        factory('App\Product', 50)->create();
    }
}
