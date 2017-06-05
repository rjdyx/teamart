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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/productTest','Home\TestController@index');
Route::get('/shopping','HomeController@shopping');

Route::group(['namespace'=>'Home','middleware'=>['auth']],function(){
	Route::get('/feedback','FeedbackController@index');
	Route::post('/feedback','FeedbackController@store');
});

Route::group(['prefix'=>'admin','middleware'=>['auth']],function(){
	Route::get('/', 'HomeController@index');
	Route::get('/user', 'Admin\UserController@index');
	Route::get('/user/modifypassword','Admin\UserController@modifypassword');
	Route::post('/user/{id}', 'Admin\UserController@update');
	Route::post('/user/modifypassword/{id}','Admin\UserController@updatepassword');
});

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['auth','can:admin']],function(){
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


