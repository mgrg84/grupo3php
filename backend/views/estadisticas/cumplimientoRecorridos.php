<?php
use sjaakp\gcharts\BarChart;

$this->title = Yii::t('app', 'Estadisticas');
?>


<?= BarChart::widget([
	'height' => '400px',
	'dataProvider' => $dataProvider,
	'columns' => 
	[
		'username:string',
		'comerciosRecorridos',
		'comerciosAsignados',
		/*[               // third column: tooltip
			'value' => function($model) 
			{
				return "Hola";
			},
			'type' => 'string',
			'role' => 'tooltip',
		],*/
	],
	'options' => 
	[
		'title' => 'Cumplimiento de rutas por Usuario'
	],
	]);
?>
