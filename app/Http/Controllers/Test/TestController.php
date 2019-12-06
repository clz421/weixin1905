<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class TestController extends Controller
{
	public function hello(){
	   echo "Hello World 11!";
	}

    public function redis1(){
        $key="1905";
        $vel="hello word";
        Redis::set($key,$vel);
        echo date("Y-m-d H:i:s");
    }
		
}
