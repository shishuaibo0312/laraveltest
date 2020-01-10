<?php

namespace App\Http\Controllers\Newss;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Newes;
class News extends Controller
{
    //添加的视图
    function add(){
        return view('new.add');
    }

    //添加的执行
    function add_do(){
        $post=request()->except('_token');
        $post['add_time']=time();
        //dd($post);
        $res=Newes::insert($post);
        if($res){
            echo "<script>alert('添加成功');location.href='/new/show';</script>";
        }else{
            echo "<script>alert('添加失败');location.href='/new/add';</script>";
        }
    }

    //新闻的展示
    function show(){
        $title=request()->title;
        $author=request()->author;
        $where=[];
        if($title){
            $where[]=['title','like',"%$title%"];
        }
        if($author){
            $where[]=['author','like',"%$author%"];
        }

        $data=Newes::where($where)->orderBy('new_id','desc')->paginate(2);
        $all=request()->all();
        return view('new.show',['data'=>$data,'all'=>$all]);
    }

    //新闻删除
    function destroy($new_id){
        $res=Newes::destroy($new_id);
        if($res){
            echo "<script>alert('删除成功');location.href='/new/show';</script>";
        }else{
            echo "<script>alert('删除失败');location.href='/new/show';</script>";
        }
    }

    //新闻的修改
    function update($new_id){
        $data=Newes::where('new_id','=',$new_id)->first();
        return view('new.update',['data'=>$data]);
    }

    //新闻的修改执行
    function update_do($new_id){
        $post=request()->except('_token');

        //dd($post);
        $res=Newes::where('new_id','=',$new_id)->update($post);
        if($res!=="false"){
            echo "<script>alert('修改成功');location.href='/new/show';</script>";
        }else{
            echo "<script>alert('修改失败');location.href='/new/show';</script>";
        }
    }
}
