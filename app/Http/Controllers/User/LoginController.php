<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
    public function adduser(){
        $pass ='123456abc';
        $user_name = Str::random(8);
        $email='zhangsan@qq.com';
        $password = password_hash($pass,PASSWORD_BCRYPT);
        $data=[
            'user_name' => $user_name,
            'password' => $password,
            'email' => $email,
        ];
        $uid=UserModel::insertGetId($data);
        var_dump($uid);
    }
    public function redis1(){
        $key="1905";
        $vel="hello word";
        Redis::set($key,$vel);
    }

}
