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

Route::get('/auth/geetest', 'Auth\AuthController@getGeetest');//极验
Route::get('admin/login', 'Auth\LoginController@adminLoginCreate');
Route::post('admin/login', 'Auth\LoginController@adminLogin');
Route::post('/login/check','Auth\LoginController@loginCheck');//前台登录验证
Route::get('/layout','Auth\LoginController@layout');//前台退出
Route::get('/admin/layout','Auth\LoginController@adminLayout');//后台退出
Route::get('captcha', 'KitController@captcha'); //生成验证码

// 公共接口组
Route::post('/check','UtilsController@check');//字段验证
 
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
	Route::get('/userinfo','UserController@userInfo');
});

/********************** Home - 须登录模块 (非管理员)  ***************************/
Route::group(['namespace'=>'Home','prefix'=>'home','middleware'=>['auth']],function(){
	//地址管理
	Route::resource('/address', 'AddressController');
	Route::get('/address/default/{id}','AddressController@default');

	// 订单部分
	Route::group(['prefix'=>'order'],function(){
		Route::get('/list','OrderController@index');
		Route::get('/detail/{id}','OrderController@detail');
	});

	//收藏
	Route::get('/collect','OrderController@collect');
	Route::get('/collect/del','OrderController@collectDel');
    Route::get('/collect/create','OrderController@collectCreate');
	//购物车
	Route::resource('/cart','CartController');
	Route::get('/cart/pending','CartController@pending');

	//用户部分
	
	Route::get('/userasset','UserController@userAsset');
	Route::get('/useredit','UserController@edit');
	Route::resource('/user', 'UserController');

	//意见反馈
	Route::get('/feedback','FeedbackController@index');
	Route::post('/feedback','FeedbackController@store');
});

/********************** Home - 分销商 ***************************/
Route::group(['namespace'=>'Home','prefix'=>'home','middleware'=>['auth','userRole:fx']],function(){

});

/********************** Admin - 管理员 ***************************/
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['auth','userRole:admin']
	],function(){

	Route::get('/index', 'IndexController@index');

	// 用户管理
	Route::group(['prefix'=>'user'],function(){
		Route::post('/agent/dels', 'AgentController@dels');
		Route::get('/agent/sellcount', 'AgentController@sellCount');
		Route::resource('/agent', 'AgentController');
		Route::post('/agentrole/dels', 'AgentRoleController@dels');
		Route::resource('/agentrole', 'AgentRoleController');
		Route::post('/list/dels', 'UserController@dels');
		Route::resource('/list', 'UserController');
	});

	// 商品管理
	Route::group(['prefix'=>'goods'],function(){
		Route::post('/category/dels', 'CategoryController@dels');
		Route::resource('/category', 'CategoryController');
		Route::post('/spec/dels', 'SpecController@dels');
		Route::resource('/spec', 'SpecController');
		Route::post('/brand/dels', 'BrandController@dels');
		Route::resource('/brand', 'BrandController');
		Route::post('/group/dels', 'GoodsGroupController@dels');
		Route::resource('/group', 'GoodsGroupController');
		Route::post('/list/dels', 'GoodsController@dels');
		Route::resource('/list', 'GoodsController');
		Route::post('/comment/dels', 'GoodsCommentController@dels');
		Route::resource('/comment', 'GoodsCommentController');
	});

	// 订单管理
	Route::group(['prefix'=>'order'],function(){
		Route::resource('/list', 'OrderController');
		Route::resource('/close', 'CloseController');
		Route::resource('/fade', 'FadeController');
	});

	// 报表统计管理
	Route::group(['prefix'=>'count'],function(){
		
		Route::get('/client', 'SellCountController@client');
		Route::get('/client/yearcount', 'SellCountController@clientCountYear');
		Route::get('/client/monthcount', 'SellCountController@clientCountMonth');
		Route::get('/product', 'SellCountController@product');
		Route::get('/product/ordercount', 'SellCountController@productCountOrder');
		Route::get('/agency', 'SellCountController@agency');
		Route::get('/agency/ordercount', 'SellCountController@agencyCountOrder');
	});

	// 文章管理
	Route::group(['prefix'=>'article'],function(){
		Route::post('/category/dels', 'ArticleCategoryController@dels');
		Route::resource('/category', 'ArticleCategoryController');
		Route::post('/list/dels', 'ArticleController@dels');
		Route::resource('/list', 'ArticleController');
	});

	// 活动管理
	Route::group(['prefix'=>'activity'],function(){
		Route::resource('/group', 'GroupController');
		Route::post('/group/dels', 'GroupController@dels');
		Route::resource('/activityproduct', 'ActivityProductController');
		// Route::get('/activityproduct/create/{id}', 'ActivityProductController@create');
		// Route::get('/activityproduct/create/{activity_id}/{id}', 'ActivityProductController@destory');
		Route::post('/activityproduct/dels', 'ActivityProductController@dels');
		Route::resource('/mark', 'MarkController');
		Route::post('/mark/dels',"MarkController@dels");
		Route::post('/mark/create/dels',"MarkController@dels");
		Route::resource('/roll', 'RollController');
		Route::post('/roll/dels','RollController@dels');
	});

	// 系统管理
	Route::group(['prefix'=>'system'],function(){
		Route::resource('/shop', 'ShopController');
		Route::resource('/pay', 'PayController');
		Route::resource('/send', 'SendController');
		Route::post('/ad/dels', 'AdController@dels');
		Route::resource('/ad', 'AdController');
		Route::resource('/site', 'SiteController');
		Route::post('/site/dels', 'SiteController@dels');
		Route::post('/log/dels', 'LogController@dels');
		Route::resource('/log', 'LogController');
		Route::resource('/personal', 'PersonalController');
		Route::resource('/feedback','FeedbackController');
		Route::post('/feedback/dels', 'FeedbackController@dels');
	});

});


