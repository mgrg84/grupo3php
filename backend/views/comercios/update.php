<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Comercio */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Comercio',
]) . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comercios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->nombre]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="comercio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
