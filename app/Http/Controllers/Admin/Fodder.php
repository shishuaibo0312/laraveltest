<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\Attention;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Fodders;
class Fodder extends Controller
{
    //素材的添加
    function add(){
        return view('admin.fodder.add');
    }

    //素材的添加执行
    function add_do(){
        $post=request()->except('_token','f_photo','s');
        //dd($post);

        if(request()->hasFile('f_photo')){
            $f_photo = $this->upload('f_photo');
        }
        $access_token=Wechat::getAccessToken();
        //echo   $access_token;die;

        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$post['f_format'];
        $img=$f_photo;
        $imgobj=new \CURLFile(public_path()."/".$img);
        //dd($img);
        $postData['media']=$imgobj;
        //dd($postData);
        $res= Curl::curlPost($url,$postData);
        $res=json_decode($res, true);
        //dd($res);
        $media_id=$res['media_id'];
        //var_dump($res);die;
        $post['add_time']=time();
        $post['out_time']=time()+86400*3;
        $post['media_id']=$media_id;
        $post['f_url']=$img;
        $post['f_format']=$res['type'];
        //dd($post);
        Fodders::insert($post);
        if($res){
            echo "<script>alert('添加成功');location.href='/admin/fodderlist';</script>";
        }else{
            echo "<script>alert('添加失败');location.href='/admin/fodderadd';</script>";
        }



    }

    //素材的展示\
        function list(){
        $data=Fodders::get();
        //dd($data);

        //dd($data);
        return view('admin.fodder.list',['data'=>$data]);
    }

    //素材的下载
        function getfodder(){
            $xml = file_get_contents("php://input");
            file_put_contents("1.txt", "\n" . $xml, FILE_APPEND);
            $xmlObj = simplexml_load_string($xml);
            if($xmlObj->MsgType == 'image'){
                $access_token=wechat::getAccessToken();
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

        }

    //文件上传
        function upload($file){
                if(request()->file($file)->isValid()) {
                    $photo =request()->file($file);
                    $ext=$photo->getClientOriginalExtension ();   //获取文件后缀
                    $filename=md5(uniqid()).".".$ext;
                    $store_result = $photo->storeAs('uploads',$filename);

                    return $store_result;
                }
                exit('未获取到上传文件或上传过程出错');
            }

    //公众号的消息群发
        function mass(){
            return view('admin.fodder.mass');
        }

        function mass_do(){
            $data=Attention::where('is_del','=',1)->get()->toArray();
           // dd($data);
            $openid_list=array_column($data,'openid');
        $msg=request()->msg;
           // dd($msg);
        $postData=[
            "touser"=>$openid_list,
            "msgtype"=>"text",
            "text"=>[
                "content"=>$msg
            ]
        ];
        $access_token=wechat::getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$access_token;
        $postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
        $data=Curl::curlPost($url,$postData);
        //var_dump($data);die;
    }

}
