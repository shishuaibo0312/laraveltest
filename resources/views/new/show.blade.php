@extends('layouts.common')
@section('title', '素材展示')
@section('content')
    <form>
        <input type="text" name="title" placeholder="标题" value="{{$all['title']??''}}">
        <input type="text" name="author" placeholder="作者" value="{{$all['author']??''}}" >
        <input type="submit" value="搜索">

    </form>
    <table class="table table-hover">
        <!--  <caption>上下文表格布局</caption> -->
        <thead>
        <tr class="danger">
            <td>新闻标题</td>
            <td>新闻内容</td>
            <td>作者</td>
            <td>添加时间</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr class="success">
                <td>{{$v->title}}</td>
                <td>{{$v->text}}</td>
                <td>
                  {{$v->author}}
                </td>
                <td>{{date('Y-m-d h:i:s',$v->add_time)}}</td>

                <td>

                <a href="{{url('/new/destroy',$v->new_id)}}" class="btn btn-danger">删除</a>
                <!-- <button type="button" class="btn btn-danger">删除</button> -->
                <!-- <button type="button" class="btn btn-info">修改</button> -->
                <a href="{{url('/new/update',$v->new_id)}}" class="btn btn-info">编辑</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$data->appends($all)->links()}}
    {{--->appends($all)--}}
@endsection