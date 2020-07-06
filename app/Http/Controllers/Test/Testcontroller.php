<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class Testcontroller extends Controller
{
	//测试form-data
	    function test1(){
	    	
	    	$url='http://api.1906.com/test8';
			$postData=[
				'name'	=>'yaoyao',
				'year'	=>'22',
				'img'   =>new \CURLFile('p1.jpg')
			];
			//$postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
     		$curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 返回数据格式
	        curl_setopt($curl, CURLOPT_POST, 1);  //设置以post发送
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);   //设置post发送的数据
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //关闭https验证
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
	        $output = curl_exec($curl);
	        curl_close($curl);
	        print_r($output);
	    }
	//测试urlencode
		function test2(){
			$url='http://api.1906.com/test9';
			$postData='name=yaoyao&sex=2';

			//name=test&gender=male&email=iefreer@live.cn
			//$postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
     		$curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 返回数据格式
	        curl_setopt($curl, CURLOPT_POST, 1);  //设置以post发送
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);   //设置post发送的数据
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //关闭https验证
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
	        $output = curl_exec($curl);
	        curl_close($curl);
	        print_r($output);
		}
	//测试raw
		function test3(){
			$url='http://api.1906.com/test10';
			$postData=[
				'name'	=>'yaoyao',
				'year'	=>'18'
			];
			$postData=json_encode($postData);
     		$curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 返回数据格式
	        curl_setopt($curl, CURLOPT_POST, 1);  //设置以post发送
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);   //设置post发送的数据
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //关闭https验证
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
	        $output = curl_exec($curl);
	        curl_close($curl);
	        print_r($output);
		}

	//测试签名
		function test4(){
    		$key='1906';
    		$data="yaoyao";
    		$sign=md5($key.$data);
    		
    		
	        //$url="http://api.1906.com/test11?data=".$data."&sign=".$sign;  //接口服务器地址
	        $url="https://1906shishuaibo.comcto.com/test11?data=".$data."&sign=".$sign;  //接口服务器地址
	        //https://1906shishuaibo.comcto.com/test11
	        echo $url;echo "<br>";echo "<br>";
	        $curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 返回数据格式
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//关闭https验证
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
	        $output = curl_exec($curl);
	        curl_close($curl);
	        print_r($output);
    	}
    //测试加密与解密
    	function test5(){
    		$str='Lucky';
    		$length=strlen($str);
    		$miwen='';
    		for ($i=0; $i <$length ; $i++) { 
    			$miwen.=chr(ord($str[$i])+3);
    		}
    		echo "密文：".$miwen;
    		echo "<br>";
    		$url='http://api.1906.com/test12?miwen='.$miwen;

    		//$res=file_get_contents($url);
    		$curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 返回数据格式
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//关闭https验证
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
	        $output = curl_exec($curl);
	        curl_close($curl);
	        print_r($output);
    		//var_dump($res);
    	}

    //测试签名与加密
    	function test6(){
    		$key='1906';				//双方共用的key
    		$data='yaoyao';				//传输的数据
    		// echo "发送的数据：".$data;
    		// echo  "<hr>";
    		
    		$sign=md5($key.$data);		//传送方的签名
    		$method='aes-128-cbc';		//加密的方式
    		$iv='abcdefg123456789';     //必须保证有16个字节
    		// openssl_encrypt ( string $data , string $method , string $key [, int $options = 0 [, string $iv = "" [, string &$tag = NULL [, string $aad = "" [, int $tag_length = 16 ]]]]] ) : string
    		$result=openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);	//加密的数据
    		$result=base64_encode($result);										//base64 编码后的加密数据
    		//echo $result;die;
    		$url='http://api.1906.com/test13?sign='.$sign.'&result='.$result;
    		$res=file_get_contents($url);
    		
    		var_dump($res);


    	}

    //测试非对称性加密
    	function test7(){
    		$key=file_get_contents(storage_path('keys\pub_api.key'));		//公钥
    		
    		$data='yaoyao';
    		echo "传输的数据为：".$data."<br>";
    		//openssl_public_encrypt ( string $data , string &$crypted , mixed $key [, int $padding = OPENSSL_PKCS1_PADDING ] ) : bool
    		openssl_public_encrypt($data,$jiami,$key);
    		//var_dump($jiami);
    		$jiami=base64_encode($jiami);
    		echo "加密的数据为：".$jiami."<br>"."<hr>";
    		$url="http://api.1906.com/test14?data=".urlencode($jiami);
    		$res=file_get_contents($url);
    		//echo $res;die;
    		$key2=file_get_contents(storage_path('keys/priv_wx.key'));
    		$msg=openssl_private_decrypt($res,$result,$key2);
    		// while ($msg = openssl_error_string())
    		// 	echo $msg . "<br />\n";
    		// die;
    		var_dump($msg);
    		echo "通讯结果为：".$result;
    	}

    //检测非对称性签名
    	function  test8(){
    		$data='yaoyao';
    		//openssl_sign ( string $data , string &$signature , mixed $priv_key_id [, mixed $signature_alg = OPENSSL_ALGO_SHA1 ] ) : bool
    		$key=openssl_pkey_get_private("file://".storage_path('keys/priv_wx.key'));
    		//dd($key);
    		openssl_sign($data,$sign,$key,OPENSSL_ALGO_SHA1);
    		//echo $sign;
    		$sign=base64_encode($sign);
    		//echo $sign;die;
    		$url="http://api.1906.com/test15?data=".$data.'&sign='.urlencode($sign);
    		//echo $url;die;
    		$res=file_get_contents($url);
    		var_dump($res);

    	}

        function adduser(){
            for($i=0;$i<500000;$i++){
                $data=[
                    'user_name'=>Str::random(8),
                    'email'=>Str::random(10).'@qq.com',
                    'pass'=>password_hash(Str::random(8),PASSWORD_BCRYPT),
                    'mobile'=>'13'.mt_rand(111111111,999999999),
                ];
                DB::table('users_100000_a')->insertGetId($data);
            }
        }
		
}
