@extends('layouts.common')
@section('title', '素材展示')
@section('content')
<table class="table table-hover">
    <!--  <caption>上下文表格布局</caption> -->
    <thead>
    <tr class="danger">
        <td>素材编号</td>
        <td>素材名称</td>
        <td>素材展示</td>
        <td>媒体格式</td>
        <td>微信服务器标识</td>
        <td>添加时间</td>
        <td>过期时间</td>
    </tr>
    </thead>
    <tbody>
@foreach($data as $v)
        <tr class="success">
            <td>{{$v->f_id}}</td>
            <td>{{$v->f_name}}</td>
            <td>
                @if($v->f_format == "image")
                    <img src="\{{$v->f_url}}" width="100px">
                @elseif($v->f_format =="voice")
                    <audio src="\{{$v->f_url}}" width="100px"  height="50px" controls="controls" ></audio>
                @elseif($v->f_format == "video")
                    <video src="\{{$v->f_url}}"  width="100px"  height="50px" controls="controls" style="width:100%; height:100%; object-fit: fill"></video>
                @endif
            </td>
            <td>
                {{$v->f_format == "image" ? "图片" : ''}}
                {{$v->f_format == "voice" ? "音频" : ''}}
                {{$v->f_format == "video" ? "视频" : ''}}
            </td>
            <td>{{$v->media_id}}</td>
            <td>{{date('Y-m-d h:i:s',$v->add_time)}}</td>
            <td>{{date('Y-m-d h:i:s',$v->out_time)}}</td>
            {{--<td>--}}

                {{--<a href="" class="btn btn-danger">删除</a>--}}
                {{--<!-- <button type="button" class="btn btn-danger">删除</button> -->--}}
                {{--<!-- <button type="button" class="btn btn-info">修改</button> -->--}}
                {{--<a href="" class="btn btn-info">编辑</a>--}}
            {{--</td>--}}
        </tr>
@endforeach
    </tbody>
</table>
    @endsection