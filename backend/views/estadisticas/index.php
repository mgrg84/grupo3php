<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ComercioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Estadisticas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comercio-index">

    <h1><?= Html::encode($this->title) ?></h1>

	<div id="tabs">
	  <ul>
		<li><a id="t1" href="#tabs-1">Mas Vendidos</a></li>
		<li><a id="t2" href="#tabs-2">Realizacion de Recorridos</a></li>
		<li><a id="t3" href="#tabs-3">Ventas</a></li>
	  </ul>
	  <div id="tabs-1">
		<iframe src="<?php echo Yii::$app->request->baseUrl. '/estadisticas/productsalesbymarket'?>"></iframe>
	  </div>
	  <div id="tabs-2">
	  </div>
	  <div id="tabs-3">
	  </div>
	</div>


</div>
<script>

	$(function() {
		$( "#tabs" ).tabs();
	});
	
	$("#t1").on("click", function()
	{
		$("#tabs-1").load('<?php echo Yii::$app->request->baseUrl. '/estadisticas/productsalesbymarket'?>');
	/*	$.ajax({
			url: '<?php echo Yii::$app->request->baseUrl. '/estadisticas/productsalesbymarket'?>',
			type: 'get',
			data: {},
			success: function (data)
			{
				$("#tabs-1").html(data);
			}
		});*/
	});
	
	$("#t2").on("click", function()
	{
		$.ajax({
			url: '<?php echo Yii::$app->request->baseUrl. '/estadisticas/successRoutesByUser' ?>',
			type: 'get',
			success: function (data)
			{
				$("#tabs-1").html(data);
			}
		});
	});
	
	$("#t3").on("click", function()
	{
		
	});
</script>

