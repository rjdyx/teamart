<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/','HomeController@index');//首页

// Home - 无须登录模块
Route::group(['namespace'=>'Home','prefix'=>'home'],function(){
	// Route::get('/productTest','Home\TestController@index');
	// 商品列表、详情
	Route::group(['prefix'=>'product'],function(){
		Route::get('/list','ProductController@list');
		Route::get('/detail/{id}','ProductController@detail');
	});
	// 帮助中心列表、详情
	Route::group(['prefix'=>'help'],function(){
		Route::get('/list','HelpController@list');
		Route::get('/detail/{id}','HelpController@detail');
	});
});

// Home - 须登录模块 (普通会员)
Route::group(['namespace'=>'Home','prefix'=>'home'
	// ,'middleware'=>['auth']
	],function(){
	Route::resource('/address', 'AddressController');
	// 订单列表、详情
	Route::group(['prefix'=>'order'],function(){
		Route::get('/list','OrderController@list');
		Route::get('/detail/{id}','OrderController@detail');
	});
	Route::get('/feedback','FeedbackController@index');
	Route::post('/feedback','FeedbackController@store');
});

// Home - 分销商 模块
Route::group(['namespace'=>'Home','prefix'=>'home','middleware'=>['auth','can:fx']],function(){

});

// Admin - 管理员 模块
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['auth','can:admin']],function(){
	Route::get('/user/modifypassword','Admin\UserController@modifypassword');
	Route::post('/user/modifypassword/{id}','Admin\UserController@updatepassword');
	Route::resource('/users', 'UsersController');
	Route::resource('/productCategory','ProductCategoryController');
	Route::resource('/product','ProductController');
	Route::resource('/product/{pid}/type','ProductTypeController');
	Route::resource('/product/{pid}/image','ProductImageController');
	Route::get('/feedback','FeedbackController@index');
	Route::post('/distributor/sortByName','DistributorController@sortByName');
	Route::resource('/distributor','DistributorController');
	Route::post('/distributor/add','DistributorController@add');
});


