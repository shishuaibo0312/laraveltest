<?php

for($i=1;$i<=100;$i++){
    echo "<button class='click'>$i</button>";
    if($i%10==0){
        echo "<br>";
    }
}

?>

<script type="text/javascript" src="./jquery.js"></script>
<script type="text/javascript">

    $(function(){
        $.ajax({
            method: "GET",
            url: "zrange.php",
            async:false
        }).done(function(res){

            // var res='''+res+''';
            //    		console.log(res);

            var array = res.split(',')
            var cc=typeof(array);
            console.log(cc);
            var xx=array.length;
            console.log(xx);
            var click = document.getElementsByClassName("click");

            //alert(array[2]);
            for(var i=0;i<xx;i++){
                var num=array[i];
                click[num-1].style.backgroundColor = 'red';
            }

        });

        $(document).on('click','.click',function(){

            var _this=$(this);
            var number=_this.text();


            $.ajax({
                method: "POST",
                url: "click.php",
                data:{number:number},
                async:false,
            }).done(function(res) {
                console.log(res);
                if(res=='no'){
                    alert('抱歉,该座位已被人购买');exit;
                }

            });
            var yn=confirm('是否选中'+_this.text()+'号座位');
            //alert(yn);
            if(yn==true){

                this.style.backgroundColor = 'red';     //选中后座位变红色
                alert('恭喜你，选取成功');
            }


        })
    })
</script>






