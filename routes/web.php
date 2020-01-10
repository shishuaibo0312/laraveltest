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
//Route::get('hello','admin@index');

// Route::get('/','admin\login@login');
// Route::get('getplace/{id}','admin\login@getplace');
// Route::get('userlogin_do','admin\login@login_do');	
// Route::get('userlist','admin\login@list');	
// Route::get('checkname/{name}','admin\login@checkname');	
//路由分组
// Route::prefix('assay')->group(function () {
// });

//拉取代码
	Route:any('getpull','Git\Gitpull@pull');
//微信小程序后台首页
	Route::get('wxlogin','Admin\Wxlogin@wxlogin');
	Route::post('wxlogin_do','Admin\Wxlogin@wxlogin_do');

//素材管理
Route::prefix('admin')->group(function () {
	Route::get('left','Admin\Index@left');
	Route::get('index','Admin\Index@index');
	Route::get('fodderadd','Admin\Fodder@add');
	Route::post('fodderadd_do','Admin\Fodder@add_do');
	Route::get('fodderlist','Admin\Fodder@list');
	Route::post('getMeather','Admin\Index@getMeather');
	Route::any('getfodder','Admin\Fodder@getfodder');
});

//接口
Route::prefix('wechat')->group(function () {
	Route::any('wechat','Wechat\Wechat@wechats');
});
//新闻管理
Route::prefix('new')->group(function () {
	Route::any('add','Newss\News@add');
	Route::any('add_do','Newss\News@add_do');
	Route::any('show','Newss\News@show');
	Route::any('destroy/{new_id}','Newss\News@destroy');
	Route::any('update/{new_id}','Newss\News@update');
	Route::any('update_do/{new_id}','Newss\News@update_do');
});

//渠道管理
Route::prefix('channel')->group(function () {
	Route::get('channeladd','Admin\Channel@add');
	Route::post('channeladd_do','Admin\Channel@add_do');
	Route::get('channelshow','Admin\Channel@show');
	Route::get('channelchart','Admin\Channel@chart');
});

//菜单管理
Route::prefix('menu')->group(function () {
	Route::get('menuadd','Admin\Menu@add');
	Route::post('menuadd_do','Admin\Menu@add_do');
	Route::get('menushow','Admin\Menu@show');
	Route::get('getmenu','Admin\Menu@getmenu');
});
