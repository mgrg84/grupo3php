<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comercio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comercio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput() ?>

    <!--<?=  $form->field($model, 'ubicacion')->textarea(['rows' => 6]) ?>-->

    <?= $form->field($model, 'prioridad')->textInput() ?>

    <?= $form->field($model, 'horarioAtencion')->textarea(['rows' => 6]) ?>

    <h3>Dias de recorrido:</h3>
    <?= $form->field($model, 'lunes')-> checkbox() ?>

    <?= $form->field($model, 'martes')-> checkbox() ?>

    <?= $form->field($model, 'miercoles')-> checkbox()?>

    <?= $form->field($model, 'jueves')-> checkbox() ?>

    <?= $form->field($model, 'viernes')-> checkbox() ?>

    <?= $form->field($model, 'sabado')-> checkbox() ?>

    <?= $form->field($model, 'domingo')-> checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
