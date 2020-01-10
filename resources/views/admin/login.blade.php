<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
	<title>登录</title>
</head>
<body>
	<form action="{{url('/userlogin_do')}}" method="get">
		@csrf
		账号：<input type="text" name="user_name" placeholder="请输入你的用户名" class="check"><br>
		密码：<input type="password" name="user_pwd" placeholder="请输入你的密码"><br>
		省：<select class="change" name="sheng">
			<option value="">--请选择省--</option>
			@foreach($sheng as $v)
			<option value="{{$v->id}}">{{$v->name}}</option>
			@endforeach
		</select>
		市：<select class="change" name="city">
			<option value="0" selected="selected">请选择</option>
		</select>
		县：<select class="change" name="area">
			<option value="0" selected="selected">请选择</option>
		</select><br>
		<input type="submit" value="注册">
		<input type="button" value="重置">
	</form>

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
		           //console.log(res);
		            var _option="<option value=''>--请选择--</option>";
		            for(var i in res){
		              _option+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>"
		            } 
		           //console.log(_option);
		            _this.next('select').html(_option);
		          })      
		     
		    	})


	  //唯一性
	   $(document).on('blur','.check',function(){
	   	//alert(222);
	   	var _this=$(this);
	   	var name=_this.val();
	   	//alert(name);
	   	$.ajax({
          url:"{{url('checkname')}}/"+name,
          dataType:'json',
         }).done(function(res){
           //console.log(res);
           if(res==1){
           	alert('该用户名已存在');
           }
           
          })
          
	   })
})
</script>