<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comercio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comercio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ubicacion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'prioridad')->textInput() ?>

    <?= $form->field($model, 'horarioAtencion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'lunes')->textInput() ?>

    <?= $form->field($model, 'martes')->textInput() ?>

    <?= $form->field($model, 'miercoles')->textInput() ?>

    <?= $form->field($model, 'jueves')->textInput() ?>

    <?= $form->field($model, 'viernes')->textInput() ?>

    <?= $form->field($model, 'sabado')->textInput() ?>

    <?= $form->field($model, 'domingo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
