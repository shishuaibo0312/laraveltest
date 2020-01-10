@extends('layouts.common')
@section('title', '菜单添加')
@section('content')
    <h2 style="color:blue">添加菜单</h2>
    <form action="{{url('menu/menuadd_do')}}" method="post" enctype="multipart/form-data">
        @csrf
        菜单名称<br>
        <input type="text" name="channel_name"><br><br>
        菜单类型<br>
       <select>
           <option>点击类型</option>
           <option>跳转类型</option>
       </select><br><br>
        菜单标识<br>
        <input type="text" name="channel_status"><br><br>
        上级菜单<br>
        <select>
            <option>一级菜单</option>
            <option>二级菜单</option>
        </select><br><br>
        <input type="submit"  value="添加">
    </form>

@endsection