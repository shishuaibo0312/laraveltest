@extends('layouts.common')
@section('title', '渠道添加')
@section('content')
    <h2 style="color:blue">添加渠道</h2>
    <form action="{{url('channel/channeladd_do')}}" method="post" enctype="multipart/form-data">
        @csrf
        渠道名称<br>
        <input type="text" name="channel_name"><br><br>
        渠道标识<br>
        <input type="text" name="channel_status"><br><br>

        <input type="submit"  value="添加">
    </form>

@endsection