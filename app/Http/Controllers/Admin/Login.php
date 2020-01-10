<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Users;
use App\Model\Areas;
use DB;
class Login extends Controller
{
    //注册视图
    	function login(){
    		$sheng=Areas::where('pid','=',0)->get();
    		return view('admin.login',['sheng'=>$sheng]);
    	}
     //获取区域信息
      function getPlaceInfo($pid){
        //echo $pid;
        $where=[
          ['pid','=',$pid]
        ];
        return Areas::where($where)->get();
      }

      function getplace($id){
        if(!$id==0){
          $info=$this->getPlaceInfo($id);
          //dump($info);
            echo json_encode($info);
        }
      }

    //注册执行
    	function login_do(){
    		$post=request()->except('_token');
    		//dd($post);
    		$post['user_pwd']=Md5($post['user_pwd']);
    		$post['do_time']=time();
    		$res=Users::insert($post);
    		//dd($res);
    		if($res){
    			echo "<script>alert('注册成功');location.href='/userlist';</script>";
    		}else{
    			echo "<script>alert('注册失败');location.href='/userlogin';</script>";
    		}
    	}


   	//展示
   		function list(){
   			$sheng=request()->sheng;
   			$city=request()->city;
   			$area=request()->area;
   			$key=request()->key;
   			$where=[];
   			if($sheng){
   				$where[]=['sheng','=',$sheng];
   			}
   			if($city){
   				$where[]=['city','=',$city];
   			}
   			if($area){
   				$where[]=['area','=',$area];
   			}
   			if($key){
   				$where[]=['user_name','like',"%$key%"];
   			}
   			$sheng=Areas::where('pid','=',0)->get();
   			$data=Users::where($where)->get();
   			 foreach($data as $k=>$v){
		        $data[$k]['sheng']=Db::table('user_area')->where('id','=',$data[$k]['sheng'])->value('name');    
		        $data[$k]['city']=Db::table('user_area')->where('id','=',$data[$k]['city'])->value('name');
		        $data[$k]['area']=Db::table('user_area')->where('id','=',$data[$k]['area'])->value('name');
		       }
		       //dd($data);
   			return view('admin.userlist',['data'=>$data,'sheng'=>$sheng]);
   		}


   		function checkname($name){
   			//$name=request()->name;
   			//echo $name;
   			$count=Users::where('user_name','=',$name)->count();
   			if($count>0){
   				echo 1;
   			}else{
   				echo 2;
   			}
   		}
    
}
