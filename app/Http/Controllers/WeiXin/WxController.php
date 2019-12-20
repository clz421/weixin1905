<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bootstrap\HandleExceptions;
use App\Model\WxUserModel;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
class WxController extends Controller
{
    protected $access_token;

    public function __construct(){
        //获取 access_token
        $this->access_token = $this->getAccessToken();
    }

    public function getAccessToken(){
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'';
        $data_json = file_get_contents($url);
        $arr = json_decode($data_json,true);
        return $arr['access_token'];
    }



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
        $log_file = "wx.log";
        $xml_str = file_get_contents("php://input");
        $data = date('Y-m-d H:i:s') . ">>>>>\n" . $xml_str . '\n\n';
        file_put_contents($log_file,$data,FILE_APPEND);//追加写
        //处理xml数据
        $xml_obj = simplexml_load_string($xml_str);
        
        $event = $xml_obj->Event;  //获取事件类型
        $openid = $xml_obj->FromUserName;  //获取用户openID
        if($event=='subscribe'){
            
            //判断用户是否已存在
            $u = WxUserModel::where(['openid'=>$openid])->first();
            
            if($u){
                //欢迎回来
                // echo "欢迎回来";die;
                $msg = '欢迎回来';
                $xml = '<xml>
                <ToUserName><![CDATA['.$openid.']]></ToUserName>
                <FromUserName><![CDATA['.$xml_obj->ToUserName.']]></FromUserName>
                <CreateTime>'.time().'</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA['.$msg.']]></Content>
                </xml>';
                echo $xml;
            }else{
                //获取用户信息
                $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token.'&openid='.$openid.'&lang=zh_CN';
                $user_info = file_get_contents($url);
                $u = json_decode($user_info,true);
                //用户入库信息
                $user_data = [
                    'openid' => $openid,
                    'nickname' => $u['nickname'],
                    'sex' => $u['sex'],
                    'headimgurl' => $u['headimgurl'],
                    'subscribe_time' => $u['subscribe_time']
                ];
                // $log_content = date('Y-m-d H:i:s') . '>>>>>' .$user_info . '\n';
                // file_put_contents('wx_user.log',$log_content,FILE_APPEND);
                // $user_info_arr = json_decode($user_info,true);
                
                //openid 入库
                $uid =  WxUserModel::insertGetId($user_data);
                
                $msg = '谢谢关注';
                //回复用户信息
                $xml = '<xml>
                <ToUserName><![CDATA['.$openid.']]></ToUserName>
                <FromUserName><![CDATA['.$xml_obj->ToUserName.']]></FromUserName>
                <CreateTime>'.time().'</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA['.$msg.']]></Content>
                </xml>';
                echo $xml;
            }
            
        }

        //判断消息类型
        $msg_type = $xml_obj->MsgType;

        $touser = $xml_obj->FromUserName;//接受用户openid
        $fromuser = $xml_obj->ToUserName;//开发者公众号的id
        $time = time();

        $media_id = $xml_obj->MediaId;

        if($msg_type=='text'){
            $content = date('Y-m-d H:i:s') . $xml_obj->Content;//发送的消息

            $response_text = '<xml>
            <ToUserName><![CDATA['.$touser.']]></ToUserName>
            <FromUserName><![CDATA['.$fromuser.']]></FromUserName>
            <CreateTime>'.$time.'</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA['.$content.']]></Content>
            </xml>';
          echo $response_text;   //回复用户消息
        }

    }

    //获取用户基本信息
    public function getUserInfo($access_token,$openid){
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        //发送网络请求
        $json_str = file_get_contents($url);
        $log_file = 'wx_user.log';
        file_put_contents($log_file,$json_str,FILE_APPEND);
    }
    //获取素材
    // public function getMedia(){
    //     $media_id = '';
    //     $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->access_token.'&media_id='.$media_id;

    // }

}
