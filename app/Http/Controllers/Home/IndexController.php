<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //
    public function promotion($type)
    {
    	$title = "活动商品";
        return view(config('app.theme').'.home.promotion')->with(['title' => $title]);
    }
}
