<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    //
    public function index()
    {

    	$temps = \App\Product::select('title', 'salesVolume as sale','default_image_id as image')->paginate(6);
    	foreach($temps as $temp)
    	{
    		$temp['price'] = '20';
    	}
    	return json_encode($temps);
    }
}
