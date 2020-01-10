<?php

namespace App\Tools;

use Illuminate\Support\Facades\Cache;
class Wechat
{
    const appId="wxaaa2d2a93479357f";
    const appSerect="3a7bc660a3533cdedfedf2a8efce3c6d";
    //将微信的一些常用方法进行封装

    //将消息回复进行封装
        public static  function replay($xmlObj,$msg){
            echo "
                <xml>
                  <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
                  <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
                  <CreateTime>".time()."</CreateTime>
                  <MsgType><![CDATA[text]]></MsgType>
                  <Content><![CDATA[".$msg."]]></Content>
                </xml>";
        }

    //将获取微信接口凭证进行封装
        public static function getAccessToken(){
            $access_token=Cache::get('access_token');
            if(empty($access_token)){
                $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::appId."&secret=".self::appSerect;
                $data=file_get_contents($url);
                $data=json_decode($data, true);
                $access_token=$data['access_token'];
                //token如何储存2小时
                Cache::put('access_token',$access_token,7200);
            }
            //没有数据再进去调用
            return $access_token;
        }
//    //获取用户详细信息进行封装
//            public static function getUserInfo(){
//
//            }
}
