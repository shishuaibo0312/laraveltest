<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"><link rel="icon" href="https://jscdn.com.cn/highcharts/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* css 代码  */
    </style>


</head>
<body>
<h3 style="color:blue">一周气温展示</h3>
城市：<input type="text" id="city">
<button class="submit">搜索</button>（城市名为汉字或字母）
<script src="/jquery.js"></script>
<script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
<script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
<script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
<script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
<div id="container" style="min-width: 210px; height: 500px; margin: 0 auto"></div>
<script>
        $(function(){
            $.ajax({
                method: "POST",
                url: "{{url('/admin/getMeather')}}",
                data:{city:"邯郸"},
                dataType:"json",
            }).done(function(res) {
                weather(res.result);
            });
        })

        $(document).on('click','.submit',function(){
          var city=$('#city').val();
            if(city==''){
                alert('请输入城市名字');
                return;
            }
          var reg=/^[\u4e00-\u9fa5]+$|^[a-zA-Z]+$/;
            var res=reg.test(city);
           if(!res) {
                alert('城市名字必须为汉字或字母');
           }
            //alert(city);
            $.ajax({
                method: "POST",
                url: "{{url('/admin/getMeather')}}",
                data:{city:city},
                dataType:"json",
            }).done(function(res) {
                //console.log(res);
              weather(res.result);
                //console.log(categeories);

            });
        })

        function weather(weatherDate){

            var categories=[];

            var data=[];
            $.each(weatherDate,function(i,v){
                categories.push(v.days);

                var arr=[parseInt(v.temp_low),parseInt(v.temp_high)];
                data.push(arr);
                //console.log(data)
            })
            // JS 代码
            var chart = Highcharts.chart('container', {
                chart: {
                    type: 'columnrange', // columnrange 依赖 highcharts-more.js
                    inverted: true
                },
                title: {
                    text: '一周温度变化范围'
                },
                subtitle: {
                    text: weatherDate[0]['citynm']
                },
                xAxis: {
                    categories: categories
                },
                yAxis: {
                    title: {
                        text: '温度 ( °C )'
                    }
                },
                tooltip: {
                    valueSuffix: '°C'
                },
                plotOptions: {
                    columnrange: {
                        dataLabels: {
                            enabled: true,
                            formatter: function () {
                                return this.y + '°C';
                            }
                        }
                    }
                },
                legend: {
                    enabled: false
                },
                series: [{
                    name: '温度',
                    data: data
                }]
            });
        }


</script>
</body>
</html>