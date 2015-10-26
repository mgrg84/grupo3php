<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Comercio */

$this->title = 'Update Comercio: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comercios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comercio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
