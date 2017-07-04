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

// Route::get('/password/email', 'Auth\ForgotPasswordController@getEmail');
// Route::post('/password/email', 'Auth\ForgotPasswordController@postEmail');//发送密码重置链接路由
// Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@getReset');
// Route::post('/password/reset', 'Auth\ResetPasswordController@postReset');//密码重置路由
// Route::get('/reset','Auth\ForgotPasswordController@reset');
// Route::post('/reset/checkemail','Auth\ForgotPasswordController@checkemail');

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
		Route::get('/list/data','ProductController@listData');//商品列表数据接口
		Route::get('/brand','ProductController@productBrand');//商品品牌数据接口
		Route::get('/category','ProductController@productCategory');//商品分类数据接口
		Route::get('/detail/{id}','ProductController@detail');
		Route::get('/comment/{product_id}','ProductController@productComment');
		Route::get('/detail/addcart/{product_id}','ProductController@productAddCartData');
	});

	// 帮助中心列表、详情
	Route::group(['prefix'=>'help'],function(){
		Route::get('/list','HelpController@index');
		Route::get('/detail/{id}','HelpController@detail');
	});

	//站点
	Route::get('/site','SiteController@index');//加载站点列表页
	Route::get('/site/data','SiteController@indexData');//列表页数据接口
	Route::get('/site/default','SiteController@siteDefualt');//最新站点信息

	Route::get('/userinfo','UserController@userInfo');//个人中心
	Route::get('/promotion/{type}','IndexController@promotion');//获取更多模版加载
	Route::get('/index/more','IndexController@promotionData');//首页获取更多数据
});

/********************** Home - 须登录模块 (非管理员)  ***************************/
Route::group(['namespace'=>'Home','prefix'=>'home','middleware'=>['auth']],function(){
	//地址管理
	Route::post('/address','AddressController@store');
	Route::get('/address/default/{id}','AddressController@defaultaddress');
	Route::get('/address/state','AddressController@defaultState');
	Route::resource('/address', 'AddressController');

	// 订单部分
	Route::group(['prefix'=>'order'],function(){
		Route::get('/list','OrderController@index');//商品列表页
		Route::get('/detail/{id}','OrderController@detail');//商品详情页
    	Route::post('/confirm','OrderController@confirmData');//订单预处理
    	Route::get('/confirm','OrderController@confirm');//订单待支付
    	Route::get('/list/data','OrderController@orderListData');
    	Route::get('/cancell','OrderController@orderCancell');//取消订单
    	Route::get('/back','OrderController@orderBack');//退货
    	Route::get('/delivery/{order_id}','OrderController@showDelivery');//物流信息
    	Route::get('/comment/{order_id}','OrderController@orderComment');//评论
    	Route::get('/pay/{order_id}','OrderController@orderPay');//付款
    	Route::get('/site','OrderController@site');//站点地图页
    	Route::get('/site/data','OrderController@siteListData');//站点数据接口
	});


	//收藏
	Route::get('/collect/data','CollectController@ListData');
	Route::post('/collect/dels','CollectController@dels');
	Route::resource('/collect','CollectController');


	//购物车
	Route::get('/cart/data','CartController@ListData');
	Route::post('/cart/dels','CartController@dels');
	Route::resource('/cart','CartController');


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
	Route::get('/index/sells', 'IndexController@sells');

	// 用户管理
	Route::group(['prefix'=>'user'],function(){
		Route::post('/agent/dels', 'AgentController@dels');
		Route::get('/agent/sellcount', 'AgentController@sellCount');//代理商图表数据
		Route::get('/agent/record/{id}', 'AgentController@record');//佣金记录列表
		Route::get('/agent/record/solve/{id}', 'AgentController@solve');//佣金记录创建
		Route::post('/agent/record/store', 'AgentController@recordStore');//佣金记录结账处理
		Route::post('/agent/record/del', 'AgentController@recordDel');//佣金记录单条删除
		Route::post('/agent/record/dels', 'AgentController@recordDels');//佣金记录批量删除
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


