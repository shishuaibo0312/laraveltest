@extends('layouts.common')
@section('title', '新闻添加')
@section('content')
    <h2 style="color:blue">添加新闻</h2>
    <form action="{{url('new/update_do',$data->new_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        新闻标题<br>
        <input type="text" name="title" value="{{$data->title}}"><br><br>
        内容<br>
        <input type="text" name="text"  value="{{$data->text}}"><br><br>
        作者<br>
        <input type="text" name="author" value="{{$data->author}}"><br><br>
        <input type="submit"  value="修改">
    </form>

@endsection