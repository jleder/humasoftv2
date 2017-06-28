<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../controller/C_Producto.php';
$prod = new C_Producto();
$listaprod = $prod->getProductoMasVendidos();

?>
<div class="row">
    <div id="breadcrumb" class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="index.html">Dashboard</a></li>
            <li><a href="#">Charts</a></li>
            <li><a href="#">xCharts</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-search"></i>
                    <span>Número de Propuestas Creadas</span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="expand-link">
                        <i class="fa fa-expand"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <div id="xchart-1" style="height: 200px; width: 100%;"></div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-search"></i>
                    <span>Productos Más Vendidos (Litros)</span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="expand-link">
                        <i class="fa fa-expand"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <div id="xchart-2" style="height: 200px;"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
// Draw all test xCharts
    function DrawAllxCharts() {
        xGraph10();
        xGraph20();        
    }
    $(document).ready(function () {
        // Load required scripts and callback to draw
        LoadXChartScript(DrawAllxCharts);
        // Required for correctly resize charts, when boxes expand
        var graphxChartsResize;
        $(".box").resize(function (event) {
            event.preventDefault();
            clearTimeout(graphxChartsResize);
            graphxChartsResize = setTimeout(DrawAllxCharts, 500);
        });
        WinMove();
    });
    
    
    function xGraph10(){
	var tt = document.createElement('div'),
	leftOffset = -(~~$('html').css('padding-left').replace('px', '') + ~~$('body').css('margin-left').replace('px', '')),
	topOffset = -32;
	tt.className = 'ex-tooltip';
	document.body.appendChild(tt);
	var data = {
		"xScale": "time",
		"yScale": "linear",
		"main": [
			{
			"className": ".xchart-class-1",
			"data": [
				{
				  "x": "2012-11-05",
				  "y": 14
				},
				{
				  "x": "2012-11-06",
				  "y": -2
				},
				{
				  "x": "2012-11-07",
				  "y": 8
				},
				{
				  "x": "2012-11-08",
				  "y": 3
				},
				{
				  "x": "2012-11-09",
				  "y": 4
				},
				{
				  "x": "2012-11-10",
				  "y": 9
				},
				{
				  "x": "2012-11-11",
				  "y": 6
				},
				{
				  "x": "2012-11-12",
				  "y": 16
				},
				{
				  "x": "2012-11-13",
				  "y": 4
				},
				{
				  "x": "2012-11-14",
				  "y": 9
				},
				{
				  "x": "2012-11-15",
				  "y": 2
				}
			]
			}
		]
	};
	var opts = {
		"dataFormatX": function (x) { return d3.time.format('%Y-%m-%d').parse(x); },
		"tickFormatX": function (x) { return d3.time.format('%A')(x); },
		"mouseover": function (d, i) {
			var pos = $(this).offset();
			$(tt).text(d3.time.format('%A')(d.x) + ': ' + d.y)
				.css({top: topOffset + pos.top, left: pos.left + leftOffset})
				.show();
		},
		"mouseout": function (x) {
			$(tt).hide();
		}
	};
	var myChart = new xChart('line-dotted', data, '#xchart-1', opts);
}

function xGraph20(){
	var data = {
	"xScale": "ordinal",
	"yScale": "linear",
	"main": [
		{
		"className": ".xchart-class-2",
		"data": [
                    <?php
                    $contador = 0;
                    foreach ($listaprod as $value){
                        $nomprod = $value['nomprod']; 
                        $nomprodnew =str_replace("HUMA GRO ","",$nomprod);
                        
                        echo '
			{
			  "x": "'.$nomprodnew.'",
			  "y": '.$value['cantidad'].'
			},';
                    }
                    ?>			
		]
		}
		]
	};
	var myChart = new xChart('bar', data, '#xchart-2');
}
    
</script>
