<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admins;
class Wxlogin extends Controller
{
    function wxlogin(){
    //登录的视图
    		return view('admin.weixin.login');
    	}

    //登陆的执行
    	function wxlogin_do(){
    		$post=request()->except('_token');
    		//dd($post);
    		$where=[
    			['admin_name','=',$post['admin_name']],
    			['admin_pwd','=',md5($post['admin_pwd'])]
    		];
    		$res=Admins::where($where)->first();

			//dd($res);
            if($res){
                echo "<script>alert('登陆成功');location.href='/admin/left';</script>";
            }else{
                echo "<script>alert('登录失败');location.href='/wxlogin';</script>";
            }
            //dd($res);
//            $error_num=$res['error_num'];
//            $last_error_time=$res['last_error_time'];
//            $admin_id=$res['admin_id'];
//            $time=time();
//           // dd($res['admin_name']);
//            $new_time=60-ceil(($time-$last_error_time)/60);
//    		//dd($post['admin_name']);
//
//                // //密码箱等
//                if(md5($post['admin_pwd'])==$res['admin_pwd']){
//                        //第一种情况
//                        if(($res['error_num']>=3)&&($time-$last_error_time)<3600){
//                            // return redirect('wxlogin')->with('msg','账号已锁定，请在'.$new_time.'分钟后登录');
//                            echo '账号已锁定，请在'.$new_time.'分钟后登录';die;
//                               // return redirect('wxlogin');
//                               }
//
//
//                                         //否则对数据库进行更改
//                                Admins::where('admin_id','=',$res['admin_id'])
//                                                ->update(['error_num'=>0,'last_error_time'=>null]);
//                            //成功
//                            echo "<script>alert('登陆成功'); location.href='/admin/left';</script>";
//
//                }
//                //密码不正确
//                 if(md5($post['admin_pwd'])==$res['admin_pwd']){
//                     //echo 111;
//                            if(($time-$last_error_time)>=3600){
//                            Admins::where('admin_id','=',$admin_id)
//                                        ->update(['error_num'=>1,'last_error_time'=>$time]);
//
//                            if($res['error_num']<=2){
//                                  echo '密码错误，还有'.(3-($error_num)).'次机会';
//
//                            }else{
//                                  echo '密码错误，账号已被锁定';
//                            }
//                            }
//
//
//
//                            if($error_num>=3){
//                                $this->error('账号已锁定，请在'.$new_time.'分钟后登录');exit;
//                                //echo "账号已锁定，请在".$new_time."分钟后登录";exit;
//                            }
//                                Db::table('admin')->where('admin_id','=',$admin_id)
//                                            ->update(['error_num'=>$error_num+1,'last_error_time'=>$time]);
//
//                                if($res['error_num']<=1){
//                                   echo '密码错误，还'.(3-($error_num+1)).'次机会';exit;
//                                //echo "密码错误，还有".(3-($error_num+1))."次机会";exit;
//                                 }else{
//                                       echo '密码错误，账号已被锁定';exit;
//
//                               }
//
//                 }



            //      if($post['admin_name']==$res['admin_name']){
            //     echo  "ok";
            // }else{
            //     echo "<script>alert('账号错误');location.href='/wxlogin';</script>";
            // }
                    
                            
               
            
    	}
}
