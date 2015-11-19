<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DatePicker;
//use \kartik\datetime\DateTimePicker;
use kartik\datecontrol\DateControl;
use common\models\User;
use yii\helpers\ArrayHelper;

$baseUrl = Yii::$app->getUrlManager()->getBaseUrl();
$this->registerCssFile($baseUrl .'/css/jquery-ui.css');

?>


<div class="comercio-form">

    <?php $form = ActiveForm::begin(array('options' => array('id' => 'comercioForm'))); ?>

    <?= $form->field($model, 'idUsuario')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'username'))->label(Yii::t('app', 'Usuario'))?>
    <?= $form->field($model, 'fecha')->widget(DateControl::classname())?>

	<?php
	echo Html::buttonInput('Cargar comercios', [ 'onclick' => 'loadMarkets()']);
	?>
	
    <div id="comercios"></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    function loadMarkets()
    {
		if($("#ruta-fecha-disp").val() == "")
		{
			alert('Debe ingresar una fecha.');
		}
		else
		{
			$.ajax({
				url: '<?php echo Yii::$app->request->baseUrl. '/rutas/markets' ?>',
				type: 'get',
				data: { date: $("#ruta-fecha-disp").val(), userID: $("#ruta-idusuario").val() },
				success: function (data)
				{
					$("#comercios").html(data);
				}
			})
		}
    };
</script>
