<!DOCTYPE html> 
<html> 
    <head> 
        <title><?php echo $title; ?></title> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <script type="text/javascript" src="/js/springer/springer.js"></script>
        <link rel="stylesheet" href="/css/springer/master.css" /> 
        <link rel="stylesheet" href="/css/springer/themes/springer-novel-search.min.css" />
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile.structure-1.1.0.min.css" />
        <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>    
        <script src="/js/springer/jqm-autoComplete-1.3.js"></script>
        <?php if ($is_trends == true) { ?>
        <script type="text/javascript" src="/js/springer/amcharts.js"></script>
        <script type="text/javascript">    
                var chart;
                var legend;
                var chartData = [<?php echo $t_data; ?>];
    
                AmCharts.ready(function () {
                    // PIE CHART
                    chart = new AmCharts.AmPieChart();
                    chart.dataProvider = chartData;
                    chart.titleField = "month";
                    chart.valueField = "issues";
    
                    // LEGEND
                    legend = new AmCharts.AmLegend();
                    legend.align = "center";
                    legend.markerType = "circle";
                    chart.addLegend(legend);
    
                    // WRITE
                    chart.write("chartdiv");
                });
    
                // changes label position (labelRadius)
                function setLabelPosition() {
                    if (document.getElementById("rb1").checked) {
                        chart.labelRadius = 30;
                        chart.labelText = "[[title]]: [[value]]";
                    } else {
                        chart.labelRadius = -30;
                        chart.labelText = "[[percents]]%";
                    }
                    chart.validateNow();
                }
    
                // makes chart 2D/3D                   
                function set3D() {
                    if (document.getElementById("rb3").checked) {
                        chart.depth3D = 10;
                        chart.angle = 10;
                    } else {
                        chart.depth3D = 0;
                        chart.angle = 0;
                    }
                    chart.validateNow();
                }
    
                // changes switch of the legend (x or v)
                function setSwitch() {
                    if (document.getElementById("rb5").checked) {
                        legend.switchType = "x";
                    } else {
                        legend.switchType = "v";
                    }
                    legend.validateNow();
                }    
        </script>       
    <?php } ?> 
    </head>
    <body onLoad="init();"> 
    <a id="top" name="top"></a>