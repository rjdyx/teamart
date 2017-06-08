<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index')->with(['footer'=>'home']); 
    }

    public function shopping()
    {
        $products = Product::paginate(16);
        return view(config('app.theme').'.home.shopping')->with('products',$products);
    }
}
