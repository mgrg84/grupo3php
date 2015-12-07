<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use common\models\Producto;

/* @var $this yii\web\View */
/* @var $model common\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
date_default_timezone_set('America/Montevideo');
?>


<div class="pedido-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cantidad')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput(['readonly' => true, 'value' => date('Y-m-d')]) ?>

    <?= $form->field($model, 'idUsuario')->textInput() ?>

    <?= $form->field($model, 'idProducto')->dropDownList(ArrayHelper::map(Producto::find()->all(), 'id', 'nombre'))->label('Producto')?>

    <?= $form->field($model, 'idComercio')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
