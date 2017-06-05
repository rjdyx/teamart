<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(15);
        return view(config('app.theme').'.admin.product.index')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view(config('app.theme').'.admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required',  
            'category' => 'integer|required',
            'content' => 'required',
            ]);
        $product = new Product;
        $product->title = $request->title;
        $product->category_id = $request->category;
        $product->description = $request->content;
        if($product->save()){
            return Redirect::to('admin/product')->with('status', '保存成功');
        }else{
            return Redirect::back()->withErrors('保存失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = Product::find($id);
        return view(config('app.theme').'.admin.product.edit')->with('product',$product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'title' => 'required',  
            'category' => 'integer|required',
            'status' => 'in:0,1',
            'content' => 'required',
            ]);
        $product = Product::find($id);
        $product->title = $request->title;
        $product->category_id = $request->category;
        $product->description = $request->content;
        $product->status = $request->status;
        if($product->save()){
            return Redirect::to('admin/product')->with('status', '保存成功');
        }else{
            return Redirect::back()->withErrors('保存失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        if($product->delete()){
            return Redirect::back();
        }else{
            return Redirect::back()->withErrors('删除失败');
        }
    }
}
