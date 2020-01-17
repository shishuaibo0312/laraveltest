<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admins;
use App\Tools\Wechat;
use App\Tools\Curl;
use Illuminate\Support\Facades\Cookie;
class Wxlogin extends Controller
{
	//登录的视图
    	function wxlogin(){
    		return view('admin.weixin.login');
    	}

    //登陆的执行
    	function wxlogin_do(){
			$name=request()->name;
			$pwd=request()->pwd;
			$where=[
					['admin_name','=',$name],
					['admin_pwd','=',md5($pwd)]
			];
    		$res=Admins::where($where)->first();
            if(time()-$res['get_time']>300){
                return 1;
            }else{
                if($res){
                    return $res;
                }else{
                    return "no";
                }
            }
    	}

	//验证验证码
		function checkCode(){
			$name=request()->name;
			$pwd=request()->pwd;
			$where=[
				['admin_name','=',$name],
				['admin_pwd','=',md5($pwd)]
			];
			$res=rand(1000,9999);
			Admins::where($where)->update(['code'=>$res,'get_time'=>time()]);
			$admin=Admins::where($where)->first();
			$access_token=Wechat::getAccessToken();
			$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
			//请求的参数
			$postData=[
				'touser'=>'oXpDov3q_egSGr-k0zfTkJVpuKZE',
				'template_id'=>'VHLgDGRPZX26RmNqRHHvivk2NrXRWZa0Q39yZwLm1P4',
				'data'=>[
					'name'=>[
						'value'=>$admin['admin_name'],
						'color'=>'#173177',
					],
					'code'=>[
						'value'=>$res,
						'color'=>'#173177',
					],
					'time'=>[
						'value'=>'5分钟',
						'color'=>'#173177',
					],
				],
			];
			$postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
			$res=Curl::curlPost($url,$postData);
			dump($res);
		}

}
