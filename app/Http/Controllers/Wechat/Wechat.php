<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat as Wechats;
use App\Model\Fodders;
use App\Model\Newes;
use App\Model\Channels;
use App\Model\Attention;
class Wechat extends Controller
{
    function wechats()
    {
//        $echostr = request()->echostr;
//        echo $echostr;
//        die;


//接受xml数据
        $xml = file_get_contents("php://input");

        file_put_contents("1.txt", "\n" . $xml, FILE_APPEND);

        //echo  111;die;
        $xmlObj = simplexml_load_string($xml);
//关注回复的信息
        if ($xmlObj->MsgType == 'event' && $xmlObj->Event == 'subscribe') {
            //关注时获取用户信息
            //获取access_token(微信接口凭证)
            $access_token=Wechats::getAccessToken();
            //dd($access_token);
            $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$xmlObj->FromUserName."&lang=zh_CN";
            $data=file_get_contents($url);
            $data=json_decode($data, true);
            //dd($data);
            //关注后将关注人数加1
            $channel_status=$data['qr_scene_str'];
            $openid=$data['openid'];
            $date= Channels::where('channel_status','=',$channel_status)->first();
            //dd($data);
            Channels::where('channel_status','=',$channel_status)->update(['people'=>$date['people']+1]);
            $where=[
                ['openid','=',$openid]
            ];
            $count=Attention::where($where)->count();
            if($count>0){
                Attention::where($where)->update(['is_del'=>1,'channel_status'=>$channel_status]);
            }else{
                //关注的用户信息的储存
                $user['user_name']=$data['nickname'];
                $user['sex']=$data['sex'];
                $user['city']=$data['city'];
                $user['openid']=$data['openid'];
                $user['channel_status']=$channel_status;
                Attention::insert($user);
                Attention::where('channel_status','=',$channel_status)->update(['is_del'=>1]);
            }
            //性别的区分
            $FromUserName=$data['nickname'];
            if($data['sex']==1){
                Wechats::replay($xmlObj, "欢迎".$FromUserName."先生关注");
            }
            if($data['sex']==2){
                Wechats::replay($xmlObj, "欢迎".$FromUserName."女士关注");
            }
            if($data['sex']==0){
                Wechats::replay($xmlObj, "欢迎".$FromUserName."关注");
            }
        }

//取消关注
        if ($xmlObj->MsgType == 'event' && $xmlObj->Event == 'unsubscribe') {
            //取消关注时获取用户信息
            //获取access_token(微信接口凭证)
            $access_token = Wechats::getAccessToken();
            //dd($access_token);
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $access_token . "&openid=" . $xmlObj->FromUserName . "&lang=zh_CN";
            $data = file_get_contents($url);
            $data = json_decode($data, true);
            //dd($data);
            $openid=$data['openid'];
            $where1=[
                ['openid','=',$openid],
            ];
            $user=Attention::where($where1)->first();
            //关注后将关注人数-1
            $channel_status = $user['channel_status'];
            $date = Channels::where('channel_status', '=', $channel_status)->first();
            //dd($date);
           Channels::where('channel_status', '=', $channel_status)->update(['people' => $date['people']-1]);
            Attention::where($where1)->update(['is_del'=>2]);
        }

//消息的回复
        if ($xmlObj->MsgType == 'text') {

            $content = trim($xmlObj->Content);
            $data = ['关天龙', '史佳奇', '小明', '小红', '王瑶'];
            $datt = implode(",", $data);
            $date=array_rand($data);
            if ($content == '1') {
                //echo 111;die;
                //var_dump($data);die;
                Wechats::replay($xmlObj, $datt);
            };

                 if ($content == "2") {
                     Wechats::replay($xmlObj, $data[$date]);
            }
 //天气接口
            if (mb_strpos($content, "天气") !== false) {
                $city = rtrim($content, "天气");
                if (empty($city)) {
                    $city = "邯郸";
                }
                //echo $city;die;
                $url = "http://api.k780.com/?app=weather.future&weaid=" . $city . "&&appkey=47864&sign=292ceb38c08d387cdcdb8a3e5d88a23f&format=json";
                $data = file_get_contents($url);
                $data = json_decode($data, true);
                //var_dump($data);die;
                $msg = "";
                foreach ($data['result'] as $k => $v) {
                    $msg .= $v['days'] . "  " . $v['week'] . "  " . $v['citynm'] . "  " . $v['temperature'] . "\n";
                }
                Wechats::replay($xmlObj, $msg);
            }
 //新闻关键字的搜索
            if (mb_strpos($content, "新闻+") !== false){
                $key = str_replace( "新闻+",'',$content);

               // dd($key);
                $res=Newes::where('title','like',"%$key%")->first();
               // dd($res);
                //$res = json_decode($res, true);

                if($res){
                    Wechats::replay($xmlObj, $res['text']);
                }else{
                    Wechats::replay($xmlObj, '暂无相关新闻');
                }
            }

 //新闻的普通回复
            if ($content == "最新新闻") {
                $data=Newes::orderBy('new_id','desc')->limit(1)->first();
                //$data = json_decode($data, true);
                //dd($data);
                Wechats::replay($xmlObj, $data['text']);
            };
        }

//图片的回复
        if($xmlObj->MsgType == 'image'){
            $data=Fodders::where('f_format','=','image')->get()->toArray();
            //$data = json_decode($data, true);
           //var_dump($data);die;
            $date=array_rand($data,1);

            $media_id=$data[$date]['media_id'];
           // dd($media_id);
            echo "<xml>
                  <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
                  <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
                  <CreateTime>".time()."</CreateTime>
                  <MsgType><![CDATA[image]]></MsgType>
                  <Image>
                    <MediaId><![CDATA[".$media_id."]]></MediaId>
                  </Image>
                  </xml>";
        }
//图片的下载
        if($xmlObj->MsgType == 'image'){
            $access_token=wechats::getAccessToken();
            $media_id=$xmlObj->MediaId;
            $url="https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;
            // var_dump($url);die;
            //$data=Curl::curlGet($url);
            //var_dump($data);
            $file_name=date("Ymdhis").rand(1111,9999).'.jpg';
            $data=file_get_contents($url);
            $place='weixin/image/';
           file_put_contents($place.$file_name,$data);
            //var_dump($res);
        }
        if($xmlObj->MsgType == 'video'){
            $access_token=wechats::getAccessToken();
            $media_id=$xmlObj->MediaId;
            $url="https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;
            // var_dump($url);die;
            //$data=Curl::curlGet($url);
            //var_dump($data);
            $file_name=date("Ymdhis").rand(1111,9999).'.mp4';
            $data=file_get_contents($url);
            $place='weixin/video/';
            file_put_contents($place.$file_name,$data);
            //var_dump($res);
        }

    }



}
