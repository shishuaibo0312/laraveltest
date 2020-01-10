<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Curl;
use App\Tools\Wechat;
use App\Model\Channels;
use App\Model\Attention;
class Channel extends Controller
{
    //渠道的添加视图
        function add(){
          return view('admin.channel.add');
        }

    // 渠道的添加执行
        function add_do(){
            $post=request()->except('_token','s');
            //dd($post);
            $channel_status=request()->channel_status;

            $access_token=Wechat::getAccessToken();
            $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
            //dd($url);
            $postData="{\"expire_seconds\": 2592000, \"action_name\": \"QR_STR_SCENE\", \"action_info\": {\"scene\": {\"scene_str\": \"$channel_status\"}}}";
           // dd($postData);
            $res= Curl::curlPost($url,$postData);
            //var_dump($res);die;
            $res=json_decode($res, true);
            $post['ticket']=$res['ticket'];
            //dd($post);
            $res=Channels::insert($post);
            if($res){
                echo "<script>alert('添加成功');location.href='/channel/channelshow';</script>";
            }else{
                echo "<script>alert('添加失败');location.href='/channel/channeladd';</script>";
            }
        }

    //渠道的展示
        function show(){
            $data=Channels::get();

            return view('admin.channel.show',['data'=>$data]);
        }

    //二维码的获取
//        function getcode(){
//            $access_token="29_q9pMaw97QCsCofjqVcN4xWMNJIA_SX836kggOVWc9ZME5ZRoKg2Vcw4tyyOd7Y77HFfkAKqDWdA4-5LRdfcQNU-nhV8M-ZTlRUkmq8NKWD3h2--Wq05qujxw5kEEAJhADASOX";
//            $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
//            //dd($url);
//            $postData="{\"expire_seconds\": 604800, \"action_name\": \"QR_STR_SCENE\", \"action_info\": {\"scene\": {\"scene_str\": \"1907\"}}}";
//            //dd($postData);
//            $res= Curl::curlPost($url,$postData);
//            var_dump($res);die;
//        }

//图表的展示
        function chart(){
            $data=Channels::get()->toArray();
            $channel_name=array_column($data,'channel_name');

            $channel_name="'".implode("','",$channel_name)."'";
            $people=array_column($data,'people');

            $people=implode(",",$people);
            //dd($people);
//         $date=Attention::where('is_del','=',1)->groupBy('channel_status')->get();
//         var_dump($date);die;
//            $res1=Channels::where('channel_status','=',111)->value('people');
//            $res2=Channels::where('channel_status','=',222)->value('people');
//            $res3=Channels::where('channel_status','=',333)->value('people');
            return view('admin.channel.chart',['people'=>$people,'channel_name'=>$channel_name]);
        }
}
