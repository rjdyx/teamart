<?php

namespace App\Http\Controllers\Admin;

use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = ProductCategory::whereNull('parent_id')->paginate(15);
        return view(config('app.theme').'.admin.productCategory.index')->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view(config('app.theme').'.admin.productCategory.create');
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
            'name' => 'required',  
            'parent_id' => 'integer|null'
            ]);
        $category = new ProductCategory;

        $category ->name = $request->name;
        $category ->parent_id = $request->parent;
        if($category ->save()){
            return Redirect::to('admin/productCategory')->with('status', '保存成功');
        }else{
            return Redirect::back()->withErrors('保存失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = ProductCategory::find($id);
        return view(config('app.theme').'.admin.productCategory.edit')->with('category',$category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'name' => 'required',   
            'parent_id' => 'integer|null'
            ]);
        $category = ProductCategory::find($id);

        $category ->name = $request->name;
        $category ->parent_id = $request->parent;
        if($category ->save()){
            return Redirect::to('admin/productCategory')->with('status', '保存成功');
        }else{
            return Redirect::back()->withErrors('保存失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = ProductCategory::find($id);
        $category->children()->delete();//级联删除
        if($category->delete()){
            return Redirect::back();
        }else{
            return Redirect::back()->withErrors('删除失败');
        }
    }
}
