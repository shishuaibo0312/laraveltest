@extends('layouts.common')
@section('title', '素材展示')
@section('content')
    <table class="table table-hover">
        <!--  <caption>上下文表格布局</caption> -->
        <thead>
        <tr class="danger">
            <td>菜单标号</td>
            <td>菜单名称</td>
            <td>菜单类型</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr class="success">
                <td>{{$v->f_id}}</td>
                <td>{{$v->f_name}}</td>
                <td>{{$v->media_id}}</td>
                <td>

                <a href="" class="btn btn-danger">删除</a>
                {{--<!-- <button type="button" class="btn btn-danger">删除</button> -->--}}
                {{--<!-- <button type="button" class="btn btn-info">修改</button> -->--}}
                <a href="" class="btn btn-info">编辑</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection