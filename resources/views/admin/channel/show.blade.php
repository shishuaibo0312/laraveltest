@extends('layouts.common')
@section('title', '素材展示')
@section('content')

    <table class="table table-hover">
        <!--  <caption>上下文表格布局</caption> -->
        <thead>
        <tr class="danger">
            <td>渠道名称</td>
            <td>渠道标识</td>
            <td>渠道二维码</td>
            <td>关注人数</td>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr class="success">
                <td>{{$v->channel_name}}</td>
                <td>{{$v->channel_status}}</td>
                <td><img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={{$v->ticket}}" width="50px"></td>
                <td>{{$v->people ==0 ? "暂无关注" : "$v->people"}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{--->appends($all)--}}
@endsection