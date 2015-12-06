<?php
use sjaakp\gcharts\ColumnChart;
use kartik\datecontrol\DateControl;
use yii\widgets\DatePicker;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Estadisticas');
?>
<form method="get" id="pedidosComerciosForm">
	<label class='control-label' for='dateFrom'>Desde</label>
	<?=
	 DateControl::widget([
		'name'=>'dateFrom', 
		'type'=>DateControl::FORMAT_DATE,
		'displayFormat' => 'php:d-M-y',
		'saveFormat' => 'php:y-m-d',
		]);
	?>

	<label class='control-label' for='dateTo'>Hasta</label>
	<?=
	 DateControl::widget([
		'name'=>'dateTo', 
		'type'=>DateControl::FORMAT_DATE,
		'autoWidget'=>true,
		'displayFormat' => 'php:d-M-Y',
		'saveFormat' => 'php:y-m-d',
		]);

	?>
	<?= Html::button('Filtrar', ['type' => 'submit', 'class' => 'btn btn-success', 'style' => 'margin-top:10px;']);?>
	
</form>

<div style="margin-top:20px;">
<?= ColumnChart::widget([
	'height' => '400px',
	'dataProvider' => $dataProvider,
	'columns' => 
	[
		'comercio.nombre:string',
		'cantidad',
	],
	'options' => 
	[
		'title' => 'Pedidos por comercio'
	],
	]);
?>
</div>
