<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/static/css/animate.css" rel="stylesheet">
    <link href="/static/css/style.css" rel="stylesheet">
    <link href="/static/css/login.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>
        if (window.top !== window.self) {
            window.top.location = window.location;
        }
    </script>

</head>

<body class="signin">
    <div class="signinpanel">
        <div class="row">
            <div class="col-sm-12">
                {{session('msg')}}
                <form method="post" action="{{url('wxlogin_do')}}">
                    @csrf
                    <h4 class="no-margins">登录：</h4>
                    <p class="m-t-md">登录到H+后台主题UI框架</p>
                    <input type="text" class="form-control uname" name="admin_name" placeholder="用户名" id="name" />
                    <input type="password" class="form-control pword m-b" name="admin_pwd" placeholder="密码"  id="pwd"/>
                    <input type="text" name="code"  class="form-control" placeholder="验证码" id="code" />
                    <input type="button" value="点击获取" style="color:#00ffff" class="click">
                    <input type="button" value="登录"  id="submit" class="btn btn-success btn-block">
                </form>
            </div>
        </div>
        <div class="signup-footer">
            <div class="pull-left">
                &copy; hAdmin
            </div>
        </div>
    </div>
</body>

</html>
<script src="/jquery.js"></script>
<script>
    $(function(){
        //点击获取验证码
        $(document).on('click','.click',function(){
            var code=$("#code").val();
            var name=$('#name').val();
            var pwd=$('#pwd').val();
            if(name==''){
                alert('账号必填');
                return false;
            }
            if(pwd==''){
                alert('密码必填');
                return false;
            }
            $.ajax({
                url: "{{url('/checkcode')}}",
                data:{name:name,pwd:pwd},
            })
        })

        $(document).on('click','#submit',function(){
            var code=$("#code").val();
            var name=$('#name').val();
            var pwd=$('#pwd').val();
            $.ajax({
                method: "POST",
                url: "{{url('/wxlogin_do')}}",
                data:{name:name,pwd:pwd},
            }).done(function(res) {
                //console.log(res);
                if(res=="no"){
                    alert('账号或密码不正确');
                    return false;
                }else if(res==1){
                   alert('验证码已过期');
                    return false;
                }else{
                    if(res['code']==code){
                        alert('登陆成功');location.href='/admin/left';
                    }else{
                        alert('验证码错误');
                        return false;
                    }
                }
            });
        })
    })
</script>

