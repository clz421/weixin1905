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

}
