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

Route::get('admin/login', 'Auth\LoginController@adminLoginCreate');
Route::post('admin/login', 'Auth\LoginController@adminLogin');
Route::get('/layout','Auth\LoginController@layout');//前台退出
Route::get('/admin/layout','Auth\LoginController@adminLayout');//后台退出

Auth::routes();
Route::get('/','HomeController@index');//首页

// Home - 无须登录模块
Route::group(['namespace'=>'Home','prefix'=>'home'],function(){

	// 商品列表、详情
	Route::group(['prefix'=>'product'],function(){
		Route::get('/list','ProductController@index');
		Route::get('/detail/{id}','ProductController@detail');
	});
	// 帮助中心列表、详情
	Route::group(['prefix'=>'help'],function(){
		Route::get('/list','HelpController@index');
		Route::get('/detail/{id}','HelpController@detail');
	});
});

// Home - 须登录模块 (普通会员)
Route::group(['namespace'=>'Home','prefix'=>'home','middleware'=>['auth']],function(){

	//地址管理
	Route::resource('/address', 'AddressController');

	// 订单部分
	Route::group(['prefix'=>'order'],function(){
		Route::get('/list','OrderController@index');
		Route::get('/detail/{id}','OrderController@detail');
	});

	//收藏
	Route::get('/collect','OrderController@collect');

	//购物车
	Route::get('/cart','CartController@index');

	//用户部分
	Route::get('/userinfo','UserController@userInfo');
	Route::get('/userasset','UserController@userAsset');
	Route::get('/useredit','UserController@edit');
	Route::resource('/user', 'UserController');

	//意见反馈
	Route::get('/feedback','FeedbackController@index');
	Route::post('/feedback','FeedbackController@store');
});

// Home - 分销商 模块
Route::group(['namespace'=>'Home','prefix'=>'home','middleware'=>['auth','userRole:fx']],function(){

});

// Admin - 管理员 模块
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['auth','userRole:admin']
	],function(){

	Route::get('/index', 'IndexController@index');

	// 用户管理
	Route::group(['prefix'=>'user'],function(){
		Route::resource('/agent', 'AgentController');
		Route::post('/agentrole/dels', 'AgentRoleController@dels');
		Route::resource('/agentrole', 'AgentRoleController');
		Route::resource('/list', 'UserController');
	});

	// 商品管理
	Route::group(['prefix'=>'goods'],function(){
		Route::resource('/category', 'CategoryController');
		Route::resource('/spec', 'SpecController');
		Route::resource('/brand', 'BrandController');
		Route::resource('/group', 'GoodsGroupController');
		Route::resource('/list', 'GoodsController');
		Route::resource('/comment', 'GoodsCommentController');
	});

	// 订单管理
	Route::group(['prefix'=>'order'],function(){
		Route::resource('/list', 'OrderController');
		Route::resource('/deliver', 'DeliverController');
		Route::resource('/fade', 'FadeController');
	});

	// 报表统计管理
	Route::group(['prefix'=>'count'],function(){
		Route::get('/client', 'SellCountController@client');
		Route::get('/product', 'SellCountController@product');
		Route::get('/agency', 'SellCountController@agency');
	});

	// 文章管理
	Route::group(['prefix'=>'article'],function(){
		Route::resource('/category', 'ArticleCategoryController');
		Route::resource('/list', 'ArticleController');
	});

	// 活动管理
	Route::group(['prefix'=>'activity'],function(){
		Route::resource('/group', 'GroupController');
		Route::resource('/mark', 'MarkController');
		Route::resource('/roll', 'RollController');
	});

	// 系统管理
	Route::group(['prefix'=>'system'],function(){
		Route::resource('/shop', 'ShopController');
		Route::resource('/pay', 'PayController');
		Route::resource('/send', 'SendController');
		Route::resource('/ad', 'AdController');
		Route::resource('/site', 'SiteController');
		Route::resource('/log', 'LogController');
		Route::resource('/personal', 'PersonalController');
	});

});


