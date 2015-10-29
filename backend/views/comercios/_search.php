<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ComercioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comercio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'ubicacion') ?>

    <?= $form->field($model, 'prioridad') ?>

    <?php // echo $form->field($model, 'lunes') ?>

    <?php // echo $form->field($model, 'martes') ?>

    <?php // echo $form->field($model, 'miercoles') ?>

    <?php // echo $form->field($model, 'jueves') ?>

    <?php // echo $form->field($model, 'viernes') ?>

    <?php // echo $form->field($model, 'sabado') ?>

    <?php // echo $form->field($model, 'domingo') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
