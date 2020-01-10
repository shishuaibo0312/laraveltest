<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>第一个 Highcharts 图表</title>
</head>
<body>
<!-- 图表容器 DOM -->
<div id="container" style="width: 600px;height:400px;"></div>
<!-- 引入 highcharts.js -->
<script src="/static/js/highcharts.js"></script>
<script>
    // 图表配置
    var options = {
        chart: {
            type: 'bar'                          //指定图表的类型，默认是折线图（line）
        },
        title: {
            text: '各渠道关注人数统计'                 // 标题
        },
        xAxis: {
            categories: [<?php echo $channel_name;?>]   // x 轴分类
        },
        yAxis: {
            title: {
                text: '关注数量'                // y 轴标题
            }
        },
        series: [{                              // 数据列
            name: '公众号关注数量',                        // 数据列名
            data: [<?php echo $people;?>]                     // 数据
        }
        ]
    };
    // 图表初始化函数
    var chart = Highcharts.chart('container', options);
</script>
</body>
</html>