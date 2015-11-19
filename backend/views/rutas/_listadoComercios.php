<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DatePicker;
use \kartik\datetime\DateTimePicker;
use kartik\datecontrol\DateControl;
use common\models\User;
use yii\helpers\ArrayHelper;

//$baseUrl = Yii::$app->getUrlManager()->getBaseUrl();
//$this->registerCssFile($baseUrl .'/css/jquery-ui.css');

?>


<div class="input-group" style="margin:20px;">
	<?php
	foreach($comercios as $comercio)
	{
		$com = $comercio['comercio'];
		echo Html::label($com->nombre.' (distancia '.$comercio['distancia'].'mts)', 'comercio['.$com->id.']');
		echo Html::checkbox('comercio['.$com->id.']', true);
	}
	?>
</div>
