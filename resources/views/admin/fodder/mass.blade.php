@extends('layouts.common')
@section('title', '消息的群发')
@section('content')
    <h2 style="color:blue">我想群发一条消息</h2>
    <form action="{{url('admin/mass_do')}}" method="post" enctype="multipart/form-data">
        @csrf
        消息内容:<br>
        <input type="text" name="msg"><br><br>
        <input type="submit"  value="发送">
    </form>
@endsection