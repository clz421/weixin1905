<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
class TestController extends Controller
{
	public function hello(){
	   echo "Hello World!";
	}

    public function redis1(){
        $key="1905";
        $vel="hello word";
        Redis::set($key,$vel);
        echo date("Y-m-d H:i:s");
    }
    //请求百度
    public function baidu(){
        $url = 'http://news.baidu.com/';
        $client = new Client();
        $response = $client->request('GET',$url);
        echo $response->getBody();
    }

    //测试
    public function xmlTest(){
        $xml_str = '<xml><ToUserName><![CDATA[gh_f01f60fdff9d]]></ToUserName>
        <FromUserName><![CDATA[ofqPdv-BiLfv_i2qVPIWDFjQYPXk]]></FromUserName>
        <CreateTime>1576658264</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[aaa]]></Content>
        <MsgId>22572319328499231</MsgId>
        </xml>';

        $xml_obj = simplexml_load_string($xml_str);
        echo '<pre>';print_r($xml_obj);echo'</pre>';echo '<hr>';
        echo 'ToUserName：'. $xml_obj->ToUserName;echo '</br>';
        echo 'FromUserName'. $xml_obj->FromUserName;echo '</br>';


    }


}
