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
Route::get('/layout','Auth\LoginController@layout');//退出

Auth::routes();
Route::get('/','HomeController@index');//首页

// Home - 无须登录模块
Route::group(['namespace'=>'Home','prefix'=>'home'],function(){
	// Route::get('/productTest','Home\TestController@index');
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
Route::group(['namespace'=>'Home','prefix'=>'home'
	// ,'middleware'=>['auth']
	],function(){

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
	Route::resource('/user', 'UserController');

	//意见反馈
	Route::get('/feedback','FeedbackController@index');
	Route::post('/feedback','FeedbackController@store');
});

// Home - 分销商 模块
Route::group(['namespace'=>'Home','prefix'=>'home','middleware'=>['auth','can:fx']],function(){

});

// Admin - 管理员 模块
Route::group(['namespace'=>'Admin','prefix'=>'admin'
	// ,'middleware'=>['auth','can:admin']
	],function(){

	// 用户管理
	Route::group(['prefix'=>'user'],function(){
		Route::resource('/agent', 'AgentController');
		Route::resource('/agentrole', 'AgentRoleController');
		Route::resource('/list', 'UserController');
	});

	// 商品管理
	Route::group(['prefix'=>'goods'],function(){
		Route::resource('/category', 'CategoryController');
		Route::resource('/spec', 'SpecController');
		Route::resource('/brand', 'BrandController');
		Route::resource('/list', 'GoodsController');
		Route::resource('/comment', 'GoodsCommentController');
	});

	//订单管理s
	Route::resource('/order', 'OrderController');

	//活动管理
	Route::resource('/activity', 'ActivityController');

	//文章分类管理
	Route::resource('/article_category', 'ArticleCategoryController');

	//文章管理
	Route::resource('/article', 'ArticleController');

	//评论管理
	Route::resource('/comment', 'CommentController');

	//意见反馈管理
	Route::resource('/feedback', 'FeedbackController');

	//商品分类管理
	Route::resource('/product_category', 'ProductCategoryController');

	//商品管理
	Route::resource('/product', 'ProductController');

	//商品规格管理
	Route::resource('/specification', 'SpecificationController');

	//商品品牌管理
	Route::resource('/brand', 'BrandController');

	//系统管理
	Route::resource('/system', 'SystemController');
});


