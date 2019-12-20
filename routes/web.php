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
Route::get('/test/xml','Test\TestController@xmlTest');


//微信
Route::get('/wx','WeiXin\WxController@wechat');
Route::post('/wx','WeiXin\WxController@receiv');  //微信推送
Route::get('/wx/media','WeiXin\WxController@getmedia');  //获取临时素材




