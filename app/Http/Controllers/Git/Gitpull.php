<?php

namespace App\Http\Controllers\Git;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Gitpull extends Controller
{
    //git推送到github后浏览器自动拉取pull
    function pull(){
        $cmd=('cd /data/wwwroot/default/laraveltest && git pull');
        //var_dump($cmd);
        $res=shell_exec($cmd);
        var_dump($res);
    }

}
