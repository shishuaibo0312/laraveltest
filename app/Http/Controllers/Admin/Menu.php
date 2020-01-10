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

}
