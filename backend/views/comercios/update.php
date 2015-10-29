<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Comercio */

$baseUrl = Yii::$app->getUrlManager()->getBaseUrl(); 
$this->registerJsFile($baseUrl.'/assets/js/jquery.ptTimeSelect.js');
$this->registerCssFile($baseUrl .'/css/jquery.ptTimeSelect.css');
$this->registerCssFile($baseUrl .'/css/jquery-ui.css');

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Comercio',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comercios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="comercio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
