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

Route::get('/test/hello','Test\TestController@hello');
Route::get('/test/adduser','User\LoginController@adduser');
Route::get('/test/redis1','Test\TestController@redis1');
Route::get('/test/baidu','Test\TestController@baidu');

//微信
Route::get('/wx/wechat','WeiXin\WxController@wechat');


