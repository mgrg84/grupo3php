<?php
use common\models\Comercio;
use sjaakp\gcharts\ColumnChart;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Estadisticas');
?>

<div class="comercio-form">
	<form method="get" id="comercio-form">
	 <?= Html::dropDownList('marketId', $marketId, ArrayHelper::map(Comercio::find()->all(), 'id', 'nombre'), ['class' => 'form-control', 'id' => 'marketId', 'prompt' => Yii::t('app','Seleccionar comercio')])?>
	</form>
</div>

<?= ColumnChart::widget([
	'height' => '400px',
	'dataProvider' => $dataProvider,
	'columns' => 
	[
		'nombreProducto.nombre:string',
		'cantidad',
	],
	'options' => 
	[
		'title' => 'Productos mas vendidos por comercio'
	],
	]);
?>
<script>
	$("#marketId").on('change', function()
	{
		$("#comercio-form").submit();
	});
</script>