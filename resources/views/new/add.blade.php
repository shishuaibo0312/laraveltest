@extends('layouts.common')
@section('title', '新闻添加')
@section('content')
    <h2 style="color:blue">添加新闻</h2>
    <form action="{{url('new/add_do')}}" method="post" enctype="multipart/form-data">
        @csrf
        新闻标题<br>
        <input type="text" name="title"><br><br>
        内容<br>
        <input type="text" name="text"><br><br>
        作者<br>
        <input type="text" name="author"><br><br>
        <input type="submit"  value="添加">
    </form>

@endsection