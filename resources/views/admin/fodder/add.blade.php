@extends('layouts.common')
@section('title', '素材添加')
@section('content')
    <h2 style="color:blue">添加素材</h2>
    <form action="{{url('admin/fodderadd_do')}}" method="post" enctype="multipart/form-data">
        @csrf
        素材名称<br>
        <input type="text" name="f_name"><br><br>
        素材文件<br>
        <input type="file" name="f_photo"><br>
        素材类型<br>
        <input type="radio" name="f_type" value="1">临时
        <input type="radio" name="f_type" value="2">永久<br><br>
        素材格式<br>
        <select name="f_format">
            <option value="image">图片</option>
            <option value="voice">音频</option>
            <option value="video">视频</option>
        </select><br><br>
        <input type="submit"  value="添加">
    </form>

@endsection