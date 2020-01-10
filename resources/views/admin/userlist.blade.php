<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
	<title>
		
	</title>
</head>
<body>
	<form method="get">
		<select class="change" name="sheng">
			<option value="">省</option>
			@foreach($sheng as $v)
			<option value="{{$v->id}}">{{$v->name}}</option>
			@endforeach
		</select>
		<select class="change" name="city">
			<option value="0" selected="selected">市</option>
		</select>
		<select class="change" name="area">
			<option value="0" selected="selected">区</option>
		</select>
		<input type="text" name="开始时间" placeholder="">——<input type="text" name="" placeholder="结束时间">
		<input type="text" name="key" placeholder="用户名">
		<input type="submit" value="搜索">
	</form>

	<table border="1">
		<tr>
			<td>序号</td>
			<td>用户名</td>
			<td>省份</td>
			<td>市</td>
			<td>区</td>
			<td>注册时间</td>
		</tr>
		@foreach($data as $v)
		<tr>
			<td>{{$v->user_id}}</td>
			<td>{{$v->user_name}}</td>
			<td>{{$v->sheng}}</td>
			<td>{{$v->city}}</td>
			<td>{{$v->area}}</td>
			<td>{{date('Y-m-d h:i:s',$v->do_time)}}</td>
		</tr>
		@endforeach
	</table>

</body>
</html>
<script type="text/javascript" src="/jquery.js"></script>
  <script type="text/javascript">
    $(function(){
      //下拉菜单的选取
       $(document).on('change','.change',function(){
        var _this=$(this);  //表示当前要发生内容改变的下拉菜单
        //alert(111);
        _this.nextAll('select').html("<option value=''>--请选择--</option>");
        var id=_this.val();
        //console.log(id);
         $.ajax({

          url:"{{url('getplace')}}/"+id,
          dataType:'json',
         }).done(function(res){
           console.log(res);
            var _option="<option value=''>--请选择--</option>";
            for(var i in res){
              _option+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>"
            } 
           //console.log(_option);
            _this.next('select').html(_option);
          })
          
          
         
     
    })
})
</script>