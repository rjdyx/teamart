<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{

    public function run()
    {

        for($i=0; $i<10; $i++) 
        {
            DB::table('product_category')->insert([
                'name' => '商品分类自定义名称'.rand(0,1000),
                'desc' => '描述'.rand(0,1000)
            ]);  
        }

        for($i=0; $i<50; $i++) 
        {
            DB::table('spec')->insert([
                'name' => '商品规格自定义名称'.rand(0,1000),
                'desc' => '描述'.rand(0,1000)
            ]);  
        }

        for($j=0; $j<20; $j++) 
        {
            DB::table('brand')->insert([
                'name' => '品牌自定义名称'.rand(0,1000),
                'desc' => '描述'.rand(0,1000),
                'img' => 'img',
                'thumb' => 'thumb'
            ]);  
        }
        
        $categorys = DB::table('product_category')->select('id')->get();
        foreach ($categorys as $category) {
            $cids[] = $category->id;
        }

        for($j=0; $j<20; $j++) 
        {
            DB::table('product_group')->insert([
                'category_id' => $cids[rand(0,count($cids)-1)],
                'name' => '商品组自定义名称'.rand(0,1000),
                'desc' => '描述'.rand(0,1000)
            ]);  
        }

        $groups = DB::table('product_group')->select('id')->get();
        foreach ($groups as $group) {
            $gids[] = $group->id;
            DB::table('product_img')->insert([
                'group_id' => $group->id,
                'img' => 'img',
                'thumb' => 'thumb'
            ]);  
        }

        $brands = DB::table('brand')->select('id')->get();
        foreach ($brands as $brand) {
            $bids[] = $brand->id;
        }

        $users = DB::table('user')->select('id')->get();
        foreach ($users as $user) {
            $uids[] = $user->id;
        }

        $specs = DB::table('spec')->select('id')->get();
        foreach ($specs as $spec) {
            $sids[] = $spec->id;
        }

        for($v=0; $v<50; $v++) 
        {
            DB::table('product')->insert([
                'category_id' => $cids[rand(0,count($cids)-1)],
                'brand_id' => $bids[rand(0,count($bids)-1)],
                'group_id' => $gids[rand(0,count($gids)-1)],
                'user_id' => $uids[rand(0,count($uids)-1)],
                'spec_id' => $sids[rand(0,count($sids)-1)],
                'name' => '商品自定义名称'.rand(0,1000),
                'desc' => '描述'.rand(0,1000),
                'stock' => rand(0,100),
                'low_stock' => rand(0,100),
                'price' => rand(0,500),
                'price_raw' => rand(0,500),
                'grade' => 1,
                'state' => 1
            ]);  
        }

    }
}
