<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DatePicker;
use \kartik\datetime\DateTimePicker;
use kartik\datecontrol\DateControl;
use common\models\User;
use yii\helpers\ArrayHelper;
use backend\Code\Helpers;

//$baseUrl = Yii::$app->getUrlManager()->getBaseUrl();
//$this->registerCssFile($baseUrl .'/css/jquery-ui.css');

?>

<h3><?= Yii::t('app', 'Comercios disponibles:') ?></h3>
<div style="margin:20px;">
	<?php
	if(count($comercios) == 0)
	{
		echo "<h4>".Yii::t('app', 'No se encontraron comercios con los filtros indicados')."</h4>";
	}
	else
	{
	echo "<input id='userLat' type='hidden' value='".$comercios[0]['ubicacionUsuario'][0]."'/>";
	echo "<input id='userLng' type='hidden' value='".$comercios[0]['ubicacionUsuario'][1]."'/>";
	echo "<table class='table table-striped table-bordered'>";
	echo "<thead>";
	echo "<th>".Yii::t('app', 'Nombre')."</th>";
	echo "<th>".Yii::t('app', 'Distancia(mts)')."</th>";
	echo "<th>".Yii::t('app', 'Prioridad')."</th>";
	echo "<th/>";
	echo "</thead>";
	echo "<tbody>";
		foreach($comercios as $comercio)
		{
			echo "<tr>";
			$com = $comercio['comercio'];
			echo "<td>".$com->nombre."</td>";
			echo "<td>".$comercio['distancia']."</td>";
			echo "<td>".Yii::t('app', Helpers::GetPriorityDescription($com->prioridad))."</td>";
			echo "<td>".Html::checkbox('comercio['.$com->id.']', true, $com->prioridad == 2 ? ['disabled' => '', 'ubicacion'=> $com->ubicacion, 'id' => "comID".$com->id ] : ['ubicacion'=> $com->ubicacion, 'id' => "comID".$com->id ])."</td>";
			echo "</tr>";
		}
	echo "</tbody>";
	echo "</table>";
	}
	?>
</div>
