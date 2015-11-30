<div class="col-sm-5">

<?php
use scotthuangzl\googlechart\GoogleChart;


 echo GoogleChart::widget(array('visualization' => 'BarChart',
    'data' => array(
		array('Producto', 'unidades vendidas'),
        array('2004', 1000),
        array('2005', 1170),
        array('2006', 660),
        array('2007', 1030),
    ),
    'options' => array(
	'title' => 'Ventas de productos',
	'titleTextStyle' => array('color' => '#FF0000'),
	'curveType' => 'function', //smooth curve or not
	'legend' => array('position' => 'bottom'),
	)));

?>
</div>