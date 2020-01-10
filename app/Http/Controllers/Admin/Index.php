<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class Index extends Controller
{
	//后台首页
	function left()
	{
		return view('admin.weixin.left');
	}

	//主页
	function index()
	{
		return view('admin.weixin.index');
	}

	//主页天气接口的ajax
	function getMeather()
	{
		$city = request()->city;
		//echo $city;
		$cache_name='weatherData_'.$city;
		$res=Cache::get($cache_name);
		if(empty($res)){
			//echo "走查询接口";
			//调用天气接口
			$url = "http://api.k780.com/?app=weather.future&weaid=" . $city . "&&appkey=47864&sign=292ceb38c08d387cdcdb8a3e5d88a23f&format=json";
			$res = file_get_contents($url);
			//$data = json_decode($data, true);
			$time24=strtotime(date("Y-m-d"))+86400;
			$second=$time24-time();
			Cache::put($cache_name,$res,$second);
		}

		 return $res;

	}
}
