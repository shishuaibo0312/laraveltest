<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
class Menu extends Controller
{
    //菜单管理
    //菜单的添加
        function add(){
            return view('admin.menu.add');
        }

    //菜单的添加执行
    //菜单的展示


    //模拟菜单的添加
        function getmenu(){
            $access_token=Wechat::getAccessToken();
            $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
            $postData=[
                "button"    => [
                    [
                        "type"  => "location_select",
                        "name"  => "发送位置",
                        "key"   => "rselfmenu_2_0"
                    ],
                    [
                        "name"  => "工具",
                        "sub_button"    => [
                            [
                                "type"  => "scancode_push",
                                "name"  => "扫一扫",
                                "key"   => "scan111"
                            ],
                            [
                                "type"  => "pic_sysphoto",
                                "name"  => "拍照",
                                "key"   => "photo111"
                            ]
                        ]
                    ],
                ]
            ];
            $postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
            $data=Curl::curlPost($url,$postData);
            var_dump($data);die;
        }

    //引导用户授权
    public function test()
    {
        //$redis_key = 'checkin:'.date('Y-m-d');
        //echo $redis_key;die;
        $appid = env('MENU_APPID');
        $redirect_uri = urlencode(env('MENU_AUTH_REDIRECT_URI'));
//        $appid ='wxaaa2d2a93479357f';
//        $redirect_uri =urlencode('http://1906shishuaibo.comcto.com/menu/auth');
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        echo $url;
    }
    /**
     * 接收网页授权code
     */
    public function auth()
    {
        // 接收 code
        $code = $_GET['code'];
        //换取access_token
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('MENU_APPID').'&secret='.env('MENU_SECRET').'&code='.$code.'&grant_type=authorization_code';
        $json_data = file_get_contents($url);
        $arr = json_decode($json_data,true);
        echo '<pre>';print_r($arr);echo '</pre>';
        // 获取用户信息
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$arr['access_token'].'&openid='.$arr['openid'].'&lang=zh_CN';
        $json_user_info = file_get_contents($url);
        $user_info_arr = json_decode($json_user_info,true);
        //将用户信息保存至 Redis HASH中
        $key = 'h:user_info:'.$user_info_arr['openid'];
        Redis::hMset($key,$user_info_arr);
        echo '<pre>';print_r($user_info_arr);echo '</pre>';
        //实现签到功能 记录用户签到
        $redis_key = 'checkin:'.date('Y-m-d');
        Redis::Zadd($redis_key,time(),$user_info_arr['openid']);  //将openid加入有序集合
        echo $user_info_arr['nickname'] . "签到成功" . "签到时间： ".date("Y-m-d H:i:s");
        echo '<hr>';
        $user_list = Redis::zrange($redis_key,0,-1);
        //echo '<hr>';
        //echo '<pre>';print_r($user_list);echo '</pre>';
        foreach ($user_list as $k=>$v)
        {
            $key = 'h:user_info:'.$v;
            $u = Redis::hGetAll($key);
            if(empty($u)){
                continue;
            }
            //echo '<pre>';print_r($u);echo '</pre>';
            echo " <img src='".$u['headimgurl']."'> ";
        }
    }

}
