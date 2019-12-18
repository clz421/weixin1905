<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bootstrap\HandleExceptions;
class WxController extends Controller
{
    public function wechat()
    {
        $token = '2259b56f5898cd6192c50d338723d9e4';       //开发提前设置好的 token
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $echostr = $_GET["echostr"];

        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){        //验证通过
            echo $echostr;
        }else{
            die("not ok");
        }
    }
    //推送
    public function receiv(){
        $log_file="wx.log";
        $data = json_encode($_POST);
        file_put_contents($log_file,$data,FILE_APPEND);//追加写
    }

}
