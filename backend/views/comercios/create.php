<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Comercio */

$this->title = Yii::t('app', 'Create Comercio');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comercios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="comercio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
