<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use common\models\Producto;
use common\models\Comercio;

/* @var $this yii\web\View */
/* @var $model common\models\Stock */
/* @var $form yii\widgets\ActiveForm */
date_default_timezone_set('America/Montevideo');
?>

<div class="stock-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cantidad')->textInput()->label(Yii::t('app', 'Quantity')) ?>

    <?= $form->field($model, 'fecha')->textInput(['readonly' => true, 'value' => date('Y-m-d')])->label(Yii::t('app', 'Date')) ?>

    <?= $form->field($model, 'idUsuario')->textInput(['readonly' => true, 'value' => Yii::$app->user->id])->label(Yii::t('app', 'ID User')) ?>

    <?= $form->field($model, 'idProducto')->dropDownList(ArrayHelper::map(Producto::find()->all(), 'id', 'nombre'))->label(Yii::t('app', 'Product'))?>

    <?= $form->field($model, 'idComercio')->dropDownList(ArrayHelper::map(Comercio::find()->all(), 'id', 'nombre'))->label(Yii::t('app', 'Commerce')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
